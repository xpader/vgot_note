<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/26
 * Time: 12:45
 */

namespace app\components;


class User
{

	public $id;
	public $info;
	public $isGuest = true;
	public $loginIp;
	public $loginTime;

	protected $cookieName;
	protected $validTime;
	protected $autoContinue;

	/**
	 * @param string $cookieName 保存登录 Token 的 Cookie 名称
	 * @param int $validTime 登录有效时间秒数，0则代表关闭浏览器就失效
	 * @param bool $autoGrant 是否自动鉴权，否则需要自己调用 grant() 方法进行鉴权
	 * @param bool $autoContinue 登录即将到期时是否自动延长 Token 有效时间
	 */
	public function __construct($cookieName, $validTime=0, $autoGrant=true, $autoContinue=false) {
		$this->cookieName = $cookieName;
		$this->validTime = $validTime;
		$this->autoContinue = $autoContinue;

		if ($autoGrant) {
			$this->grant();
		}
	}

	/**
	 * 获取当前用户ID
	 *
	 * @return int
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->info ? $this->info['uid'] : 0;
	}

	/**
	 * 检测登录和鉴权
	 *
	 * @return bool
	 */
	protected function grant()
	{
		$app = getApp();

		$token = $app->input->cookie($this->cookieName);
		if (!$token) return false;

		$data = static::parseLoginToken($token);

		if ($data) {
			$this->setUser($data['user']);
			$this->loginIp = $data['loginIp'];
			$this->loginTime = $data['loginTime'];

			//自动延续登录时，若登录有效期剩余不到1/4，则重新延续登录
			if ($this->autoContinue && $this->validTime > 0 &&
				time() - $data['loginTime'] < $this->validTime / 4) {
				$this->login($data['user'], false);
			}

			return true;
		} else {
			return false;
		}
	}

	/**
	 * 设置当前的用户
	 *
	 * @param array|false $user
	 */
	protected function setUser($user)
	{
		if ($user) {
			$this->info = $user;
			$this->id = $this->getId();
			$this->isGuest = false;
		} else {
			$this->id = $this->info = null;
			$this->isGuest = true;
		}
	}

	/**
	 * 登录指定用户
	 *
	 * @param array $user
	 * @param bool $trigger 是否触发用户登录时的相关动作
	 * 触发登录相关动作会触发信息更新、相关事件、钩子等
	 * 否则仅发出登录令牌存储用作登录识别，不触发其它动作
	 * @return bool
	 */
	public function login($user, $trigger=true)
	{
		if (!$user) return false;

		$token = static::generateLoginToken($user);
		if (!$token) return false;

		if ($trigger) {
			$this->setUser($user);
		}

		if ($this->cookieName) {
			$expire = $this->validTime > 0 ? $this->validTime + time() : null;
			return setcookie($this->cookieName, $token, $expire, '/');
		}

		return false;
	}

	/**
	 * 退出当前用户的登录
	 */
	public function logout()
	{
		if ($this->cookieName) {
			setcookie($this->cookieName, false, -3600, '/');
		}

		$this->setUser(false);
	}

	/**
	 * 根据ID获取用户信息
	 *
	 * @param mixed $id
	 * @return array|null
	 * @inheritdoc
	 */
	public static function findById($id)
	{
		$app = getApp();
		return $app->db->from('user')->where(['uid'=>$id])->get();
	}

	/**
	 * 解析登录Token
	 *
	 * 获取Token中的信息
	 * 如解析成功，返回的数组中 id, loginIp, loginTime, user 为必须字段
	 *
	 * @param string $token
	 * @return array|null|false
	 * @inheritdoc
	 */
	public static function parseLoginToken($token)
	{
		$app = getApp();
		$str = $app->security->decrypt($token, true);
		if (!$str) return false;

		$data = explode("\t", $str);

		if (count($data) != 4) {
			return false;
		}

		list($id, $hash, $loginIp, $loginTime) = $data;

		$user = $app->db->select('uid,username,mail,hash,regip,regtime,last_login_ip,last_login_time')
			->from('user')->where(['uid'=>$id, 'hash'=>$hash])->get();

		return compact('id', 'loginIp', 'loginTime', 'user');
	}

	/**
	 * 根据用户信息生成用于鉴权的登录Token
	 *
	 * @param array $user
	 * @return string
	 * @inheritdoc
	 */
	public static function generateLoginToken($user)
	{
		$app = getApp();
		$ip = $app->input->clientIp();
		$time = time();
		$data = "{$user['uid']}\t{$user['hash']}\t$ip\t$time";

		return $app->security->encrypt($data, true);
	}

}