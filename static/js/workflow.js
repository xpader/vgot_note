/**
 * Created by pader on 2017/8/11.
 */
function showNoteList(cateId) {
	var url = BASE_URL + "note/get-note-list";

	if (cateId) {
		url += '?cid=' + cateId;
	}

	var noteLoading = $("#noteLoading").show();

	$.get(url).done(function(res) {
		var html = '';

		var cateName = res.category ? res.category.name : "我的笔记";
		var count = res.notes.length;
		$("#noteListTitle").html(cateName);
		$("#noteListCount").html(count);

		for (var i=0,row; row=res.notes[i]; i++) {
			html += '<li><a href="javascript:;"><i class="fa fa-file-text-o"></i> ' + row.title + '</a></li>';
		}

		$("#noteList").html(html).find(">li").eq(0).addClass("active");
		noteLoading.hide();
	});
}

showNoteList();