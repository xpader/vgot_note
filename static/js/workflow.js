/**
 * Created by pader on 2017/8/11.
 */
var Editor;

function showNoteList() {
	var url = BASE_URL + "?app=note/get-list&cid=" + currentCateId;
	// var noteLoading = $("#noteLoading").show();

	$.get(url).done(function(res) {
		var html = '';

		var cateName = res.category ? res.category.name : "我的笔记";
		var count = res.notes.length;
		$("#noteListTitle").html(cateName);
		$("#noteListCount").html(count);

		var dropdown = '<div class="note-list-action dropdown">'
			+ '<a href="javascript:;" title="更多操作" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle">'
			+ '<i class="glyphicon glyphicon-option-vertical"></i>'
			+ '</a> <ul class="dropdown-menu dropdown-menu-right">'
			+ '<li><a href="javascript:;"><i class="glyphicon glyphicon-transfer"></i>移动</a></li>'
			+ '<li><a href="javascript:;" data-action="remove"><i class="glyphicon glyphicon-trash"></i>删除</a></li>'
			+ '<li role="separator" class="divider"></li>{li_share}<li role="separator" class="divider"></li>'
			+ '<li><a href="javascript:;"><i class="fa fa-history"></i>历史记录</a></li>'
			+ '<li role="separator" class="divider"></li>'
			+ '<li class="dropdown-header">{updated_at}</li>'
			+ '</ul></div>';

		for (var i=0,row; row=res.notes[i]; i++) {
			var shareLi, icon;

			//分享菜单
			switch (row.share) {
				case 1:
				case 2:
					shareLi = '<li><a href="' + row.share_url + '" target="_blank"><i class="fa fa-eye"></i>查看分享</a></li>'
						+ '<li><a href="javascript:;" data-action="share-cancel"><i class="fa fa-ban"></i>取消分享</a></li>';

					if (row.share == 2) {
						shareLi += '<li class="dropdown-header">' + row.share_expires + ' 过期</li>';
					}

					icon = 'fa fa-share-alt-square';
					break;
				case -1:
				default:
					shareLi = '<li><a href="javascript:;" data-action="share"><i class="fa fa-share-alt"></i>分享</a></li>';

					if (row.share == -1) {
						shareLi += '<li class="dropdown-header">已过期</li>';
					}

					icon = 'fa fa-file-text-o';
			}

			var menu = dropdown.replace('{li_share}', shareLi);

			html += '<li' + (row.note_id == currentNoteId ? ' class="active"' : '') + ' data-id="' + row.note_id + '">'
				+ '<a href="javascript:;" title="创建时间：' + row.created_at + '&#13;修改时间：' + row.updated_at + '">'
				+ '<i class="' + icon + '"></i> ' + row.title + '</a>' + menu.replace('{updated_at}', row.updated_at) + '</li>';
		}

		$("#noteList").html(html); //.find(">li").eq(0).addClass("active");
		// noteLoading.hide();
	});
}

function saveNote(background, leave) {
	var form = document.forms["note"];

	if (!form || form.changed.value == 0) {
		return;
	}

	$.post(BASE_URL + "?app=note/save", $(form).serialize()).done(function(res) {
		if (res) {
			if (!background) {
				if (form.id.value == 0) { //一些容错的情况
					form.id.value = res.id;
				}
				form.changed.value = 0;
				if (currentNoteId != res.id) {
					currentNoteId = res.id;
				}
			}

			if (!leave && form.cate_id.value == currentCateId) {
				setTimeout(showNoteList, 1000);
			}
		}
	});
}

function loadNote(noteId) {
	if (noteId != 0 && noteId == currentNoteId) {
		return;
	}

	saveNote(true);

	$.get(BASE_URL + "?app=note/get-note&id=" + noteId).done(function(form) {
		if (Editor) {
			//CKEDITOR.instances.editor1
			Editor.destroy();
		}

		$("#noteBox").show().html(form);
		var form = document.forms["note"];

		if (noteId == 0) {
			form.title.focus();
		}

		//初始化编辑器
		Editor = CKEDITOR.replace('editor1');
		Editor.on('loaded', adjustEditor);

		currentNoteId = form.id.value;

		if (currentNoteId == 0) {
			form.cate_id.value = currentCateId;
		}

		$(form.title).on('change', function() {
			form.changed.value = 1;
		}).on('blur', function() {
			saveNote();
		});

		Editor.on('change', function(e) {
			form.content.value = e.editor.getData();
			form.changed.value = 1;
		});

		Editor.on('blur', function(e) {
			saveNote();
		});
	});
}

function adjustEditor() {
	var h = $(window).height() - $(".navbar-static-top").height() - $("#noteHeader").height();

	if (Editor) {
		Editor.resize('100%', h);
	}
}

$(function() {

	//列表功能
	var noteList = $("#noteList");

	noteList.on("click", "li[data-id]>a", function() {
		var nav = $(this).parent("li");
		var id = nav.data("id");

		if (nav.is(".active")) {
			return;
		}

		noteList.find(">.active").removeClass("active");
		nav.addClass("active");
		loadNote(id);
	});

	noteList.on("click", ".dropdown-menu a[data-action]", function() {
		var nav = $(this).closest("li[data-id]"),
			id = nav.data("id"),
			action = $(this).data("action"),
			title = $(this).attr("title");

		switch (action) {
			case "remove":
				swal({
					title: '删除笔记',
					text: "将该笔记移动到回收站？",
					type: 'warning',
					showCancelButton: true,
					confirmButtonText: '确定',
					cancelButtonText: '取消'
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
						if (Editor) {
							Editor.destroy();
						}
						$("#noteBox").hide().html('');
					}
				}, $.noop);
				break;
			case 'share':
				swal({
					title: '分享笔记',
					text: "共享该笔记后，他人将可通过链接查看笔记内容。",
					type: 'warning',
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
			case 'share-cancel':
				swal({
					title: '确定要取消分享吗？',
					type: 'warning',
					showCancelButton: true,
					confirmButtonText: '确定',
					cancelButtonText: '取消'
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

	//保存事件
	window.onbeforeunload = function() {
		saveNote(true, true);
	};

	heightAdjustCallback.add(function(wh) {
		var listBox = $("#noteList").parent();
		listBox.height(wh - listBox.prev(".box-header").outerHeight());

		adjustEditor();

		console.log(wh);
	});

});