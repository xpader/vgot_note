/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/licenseskins
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'undo', 'clipboard' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'paragraph', groups: [ 'align', 'list', 'indent', 'blocks', 'bidi', 'paragraph' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Subscript,Superscript,Cut,Copy,Paste,Styles,Format,JustifyBlock,Image,Anchor,Source';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	//config.removeDialogTabs = 'image:advanced;link:advanced';

	config.fontSize_defaultLabel = 14;
	config.font_names = '微软雅黑/Microsoft YaHei; 宋体/Simsun; 黑体/SimHei; 楷体/KaiTi; Arial; Arial Black; Consolas; Times New Roman; Verdana';

};

CKEDITOR.on('instanceReady', function(ev) {
	//ev.editor.dataProcessor.writer.selfClosingEnd = '>';
	ev.editor.dataProcessor.writer.setRules('p', {
		breakBeforeOpen: false,
		breakAfterOpen: false,
		breakBeforeClose: false,
		breakAfterClose: false
	});
});

//CKEDITOR.htmlWriter.setRules('p', {breakAfterOpen:false});

