/**
 * Created by pader on 2017/9/1.
 */
var folderLoading = $("#folderLoading");
var categoryFolders = $("#categoryFolders");
var heightAdjustCallback = $.Callbacks();

function inWorkflow() {
	return (typeof currentCateId != 'undefined');
}

function getFolders() {
	return categoryFolders.nextUntil(folderLoading, "li");
}

function toggleFocus(fd) {
	fd.toggleClass("active").find("i").toggleClass("text-aqua");
}

function showCategoryFolders(trigger) {
	folderLoading.show();

	$.get(BASE_URL + "?app=category/get-categories").done(function(res) {
		var html = '';
		var dropdown = '<div class="note-list-action dropdown">'
			+ '<a href="javascript:;" title="更多操作" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle">'
			+ '<i class="glyphicon glyphicon-option-vertical"></i>'
			+ '</a> <ul class="dropdown-menu dropdown-menu-right">'
			+ '<li><a href="javascript:;" data-action="rename"><i class="glyphicon glyphicon-edit"></i>重命名</a></li>'
			+ '<li><a href="javascript:;" data-action="delete"><i class="glyphicon glyphicon-trash"></i>删除</a></li>'
			+ '</ul></div>';

		for (var i=0,row; row=res[i]; i++) {
			html += '<li><a href="javascript:;" data-cid="' + row.cate_id + '"><i class="fa fa-folder-open"></i> <span>'
				+ row.name + '</span></a>' + (row.cate_id != 1 ? dropdown : '') + '</li>';
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

			if (inWorkflow()) {
				toggleFocus(fd);
				toggleFocus(folders.filter(".active").not(fd));

				currentCateId = cid;
				showNoteList();
			} else {
				location.href = BASE_URL + "?cid=" + cid;
			}
		});

		folders.on("click", ".dropdown-menu a[data-action]", function() {
			var action = $(this).data("action");
			var a = $(this).closest(".note-list-action").prev("a");
			var cid = a.data("cid");
			var origName = a.find("span").text();

			switch (action) {
				case "rename":
					swal({
						title: '重命名分类',
						input: 'text',
						text: '为 “' + origName + '” 指定一个新的名称',
						showCancelButton: true,
						confirmButtonText: '确定',
						cancelButtonText: '取消',
						showLoaderOnConfirm: true,
						preConfirm: function (name) {
							return new Promise(function (resolve, reject) {
								name = $.trim(name);
								if (name == "") {
									reject("请输入分类名称！");
									return;
								}

								$.post(BASE_URL + "?app=category/rename", {cid:cid, name:name}, function(res) {
									if (res.status) {
										resolve();
									} else {
										reject(res.msg);
									}
								});
							});
						},
						allowOutsideClick: false
					}).then(function() {
						showCategoryFolders(false);
					}, swal.noop);
					break;

				case "delete":
					swal({
						title: '确定要删除?',
						text: "删除分类后，该分类下的笔记将全部移到回收站!",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#d33',
						confirmButtonText: '删除 “' +　origName +'”',
						cancelButtonText: '取消'
					}).then(function () {
						swal(
							'Deleted!',
							'Your file has been deleted.',
							'success'
						)
					}, $.noop);
					break;
			}
		});

		if (inWorkflow()) {
			var currentLink = folders.find("a[data-cid=" + currentCateId + "]");

			if (trigger == undefined || trigger) {
				currentLink.trigger("click");
			} else {
				currentLink.parent().addClass("active");
			}
		}
	});
}

$(function() {

	showCategoryFolders(inWorkflow());

	//新建按钮
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

					$.post(BASE_URL + "?app=category/create", {name:name}, function(res) {
						if (res.status) {
							resolve(res.data);
						} else {
							reject(res.msg);
						}
					});
				});
			},
			allowOutsideClick: false
		}).then(function(data) {
			currentCateId = data.cate_id;
			showCategoryFolders();
		}, $.noop);
	});

	$("#newNote").click(function() {
		loadNote(0);
	});

	//自动调试调整
	var navBarHeight = $(".navbar-static-top").height();
	var wrapper = $(".content-wrapper");

	function adjustContainerHeight() {
		var wh = $(window).height() - navBarHeight;
		wrapper.height(wh+"px");

		heightAdjustCallback.fire(wh);
	}

	$(window).resize(adjustContainerHeight);
	adjustContainerHeight();

});