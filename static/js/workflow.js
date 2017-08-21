/**
 * Created by pader on 2017/8/11.
 */
var folderLoading = $("#folderLoading");
var categoryFolders = $("#categoryFolders");

function getFolders() {
	return categoryFolders.nextUntil(folderLoading, "li");
}

function toggleFocus(fd) {
	fd.toggleClass("active").find("i").toggleClass("text-aqua");
}

function showCategoryFolders() {
	folderLoading.show();

	$.get(BASE_URL + "?app=category/get-categories").done(function(res) {
		var html = '';
		for (var i=0,row; row=res[i]; i++) {
			html += '<li><a href="javascript:;" data-cid="' + row.cate_id + '"><i class="fa fa-folder-open"></i> <span>' + row.name + '</span></a></li>';
		}
		getFolders().remove();
		categoryFolders.after(html);
		folderLoading.hide();

		var folders = getFolders();
		folders.on("click", "a[data-cid]", function() {
			var cid = $(this).data("cid");
			var fd = $(this).parent("li");

			if (fd.is(".active")) {
				return;
			}

			toggleFocus(fd);
			toggleFocus(folders.filter(".active").not(fd));

			currentCateId = cid;
			showNoteList();
		});

		//folders.eq(0).find("a[data-cid]").trigger("click");
		folders.find("a[data-cid=" + currentCateId + "]").trigger("click");
	});
}

function showNoteList() {
	var url = BASE_URL + "?app=note/get-list&cid=" + currentCateId;
	var noteLoading = $("#noteLoading").show();

	$.get(url).done(function(res) {
		var html = '';

		var cateName = res.category ? res.category.name : "我的笔记";
		var count = res.notes.length;
		$("#noteListTitle").html(cateName);
		$("#noteListCount").html(count);

		for (var i=0,row; row=res.notes[i]; i++) {
			html += '<li' + (row.note_id == currentNoteId ? ' class="active"' : '') + '><a href="javascript:;" data-id="'
				+ row.note_id + '" title="创建时间：' + row.created_at + '&#13;修改时间：' + row.updated_at + '">'
				+ '<i class="fa fa-file-text-o"></i> ' + row.title + '</a></li>';
		}

		$("#noteList").html(html); //.find(">li").eq(0).addClass("active");
		noteLoading.hide();
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
				form.id.value = res.id;
				if (currentNoteId != res.id) {
					currentNoteId = res.id;
				}
			}

			if (!leave && form.cate_id.value == currentCateId) {
				showNoteList();
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
		if (CKEDITOR.instances.editor1) {
			CKEDITOR.instances.editor1.destroy();
		}

		$("#noteBox").show().html(form);
		var editor = CKEDITOR.replace('editor1'),
			form = document.forms["note"],
			chg = null;

		currentNoteId = form.id.value;

		if (currentNoteId == 0) {
			form.cate_id.value = currentCateId;
			form.changed.value = 1;
		}

		$(form.title).change(function() {
			saveNote();
		});

		editor.on('change', function(e) {
			form.content.value = editor.getData();
			form.changed.value = 1;
		});

		editor.on('blur', function(e) {
			saveNote();
		});
	});
}

$(function() {
	$("#newCate").click(function() {
		swal({
			title: '新建分类',
			input: 'text',
			showCancelButton: true,
			confirmButtonText: '创建',
			cancelButtonText: '取消',
			showLoaderOnConfirm: true,
			preConfirm: function (name) {
				return new Promise(function (resolve, reject) {
					name = $.trim(name);
					if (name == "") {
						reject("请输入分类名称！");
						return;
					}
					resolve();
				});
			},
			allowOutsideClick: false
		}).then(function(name) {
			swal({
				type: 'success',
				title: 'Ajax request finished!',
				html: 'Submitted email: ' + email
			})
		}, $.noop);
	});

	$("#newNote").click(function() {
		loadNote(0);
	});

	window.onbeforeunload = function() {
		saveNote(true, true);
	};
});