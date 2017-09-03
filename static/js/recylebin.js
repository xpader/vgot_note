/**
 * Created by pader on 2017/9/3.
 */
var NoteList = $("#noteList");

function showNoteList() {
	var url = BASE_URL + "?app=recylebin/get-list";

	$.get(url).done(function(res) {
		$("#noteListCount").html(res.length);

		var html = '',
			dropdown = '<div class="note-list-action dropdown">'
			+ '<a href="javascript:;" title="更多操作" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle">'
			+ '<i class="glyphicon glyphicon-option-vertical"></i>'
			+ '</a> <ul class="dropdown-menu dropdown-menu-right">'
			+ '<li><a href="javascript:;" data-action="restore"><i class="fa fa-recycle"></i>恢复</a></li>'
			+ '<li><a href="javascript:;" data-action="delete"><i class="fa fa-remove"></i>彻底删除</a></li>'
			+ '<li role="separator" class="divider"></li>'
			+ '<li><a href="javascript:;" data-action="empty"><i class="fa fa-eraser"></i>清空回收站</a></li>'
			+ '<li role="separator" class="divider"></li>'
			+ '<li class="dropdown-header">{updated_at}</li>'
			+ '</ul></div>';

		for (var i=0,row; row=res[i]; i++) {
			var shareLi, icon;

			html += '<li data-id="' + row.note_id + '">'
				+ '<a href="javascript:;" title="创建时间：' + row.created_at + '&#13;修改时间：' + row.updated_at + '">'
				+ '<i class="fa fa-file-text-o"></i> ' + row.title + '</a>' + dropdown.replace('{updated_at}', row.updated_at) + '</li>';
		}

		NoteList.html(html); //.find(">li").eq(0).addClass("active");
		// noteLoading.hide();
	});
}

$(function() {
	showNoteList();

	NoteList.on("click", ".dropdown-menu a[data-action]", function() {
		var nav = $(this).closest("li[data-id]"),
			id = nav.data("id"),
			action = $(this).data("action"),
			title = $(this).attr("title");

		switch (action) {
			case 'restore':
				swal({
					title: '恢复笔记？',
					text: "恢复至原先的分类，若原先的分类已不存在则恢复到默认分类。",
					showCancelButton: true,
					confirmButtonText: '确定',
					cancelButtonText: '取消'
				}).then(function () {
					return new Promise(function(resolve, reject) {
						$.post(BASE_URL + "?app=share/share", {id:id}, function(res) {
							if (res.status) {
								resolve(res.data);
							} else {
								reject(res.msg);
							}
						});
					});
				}).then(function(data) {
					swal(
						'分享成功!',
						'分享网址: <span>' + data.url + '</span>',
						'success'
					);
					showNoteList();
				}, $.noop);
				break;
			case "delete":
				swal({
					title: '删除笔记',
					text: "彻底删除该笔记后将无法恢复？",
					type: 'warning',
					showCancelButton: true,
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					confirmButtonColor: '#d33',
					allowEnterKey: false
				}).then(function () {
					return new Promise(function(resolve, reject) {
						$.post(BASE_URL + "?app=recylebin/remove", {id:id}, function(res) {
							if (res.status) {
								resolve(res.data);
							} else {
								reject(res.msg);
							}
						});
					});
				}).then(function(data) {
					swal({
						title: '删除成功',
						type: 'success',
						timer: 2000
					}).catch($.noop);

					showNoteList();

					if (id == currentNoteId) {
						$("#noteBox").hide().html('');
					}
				}, $.noop);
				break;
			case 'empty':
				swal({
					title: '确定要清空回收站吗？',
					text: '回收站中的所有笔记将被彻底删除，无法恢复。',
					type: 'error',
					showCancelButton: true,
					confirmButtonText: '清空回收站',
					cancelButtonText: '取消',
					confirmButtonColor: '#d33',
					allowEnterKey: false
				}).then(function () {
					return new Promise(function(resolve, reject) {
						$.post(BASE_URL + "?app=share/cancel", {id:id}, function(res) {
							if (res.status) {
								resolve(res.data);
							} else {
								reject(res.msg);
							}
						});
					});
				}).then(function(data) {
					swal({
						title: '已取消分享',
						type: 'success',
						timer: 1000
					}).catch($.noop);
					showNoteList();
				}, $.noop);
				break;
		}
	});


	heightAdjustCallback.add(function(wh) {
		var listBox = $("#noteList").parent();
		listBox.height(wh - listBox.prev(".box-header").outerHeight());
	});
});