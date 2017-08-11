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
			html += '<li><a href="javascript:;" data-id="' + row.note_id + '" title="创建时间：' + row.created_at + '&#13;修改时间：' + row.updated_at + '">'
				+ '<i class="fa fa-file-text-o"></i> ' + row.title + '</a></li>';
		}

		$("#noteList").html(html).find(">li").eq(0).addClass("active");
		noteLoading.hide();
	});
}

showNoteList();

(function() {
	$("#noteList").on("click", "a", function() {
		var id = $(this).data("id");
		console.log(id);
	});
})();