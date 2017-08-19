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

			showNoteList(cid);
		});

		//folders.eq(0).find("a[data-cid]").trigger("click");
		folders.find("a[data-cid=" + currentCateId + "]").trigger("click");
	});
}

function showNoteList(cateId) {
	var url = BASE_URL + "?app=note/get-list";

	if (cateId) {
		url += '&cid=' + cateId;
	}

	var noteLoading = $("#noteLoading").show();

	$.get(url).done(function(res) {
		var html = '';

		var cateName = res.category ? res.category.name : "我的笔记";
		var count = res.notes.length;
		$("#noteListTitle").html(cateName);
		$("#noteListCount").html(count);

		for (var i=0,row; row=res.notes[i]; i++) {
			html += '<li><a href="javascript:;" data-id="' + row.note_id + '" title="创建时间：' + row.created_at + '&#13;修改时间：' + row.updated_at + '">'
				+ '<i class="fa fa-file-text-o"></i> ' + row.title + '</a></li>';
		}

		$("#noteList").html(html); //.find(">li").eq(0).addClass("active");
		noteLoading.hide();
	});
}

function loadNote(noteId) {
	var url = BASE_URL + "?app=note/get-note&id=" + noteId;

	$.get(url).done(setNote);
}

function setNote(res) {
	var form = document.forms["note"];
	form.id.value = res.note_id;
	form.cate_id.value = res.cate_id;

	CKEDITOR.instances.editor1.setData(res.content);
	$("#noteTitle").html(res.title + ' <small>' + res.updated_at + '</small>');
}

$(function() {
	$("#newNote").click(function() {
		setNote({
			note_id: 0,
			cate_id: currentCateId,
			title: "",
			content: "",
			updated_at: ""
		});
	});
});