//检测对象是否为空
Object.isEmpty = function (obj) {
	return Object.keys(obj).length == 0;
};

//克隆对象
Object.clone = obj => {
	return JSON.parse(JSON.stringify(obj));
};
