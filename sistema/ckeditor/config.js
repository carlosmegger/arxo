/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
 
	config.toolbar_Simple =
	[
		{ name : 'document', items : [ 'Source','-','NewPage' ] },
		{ name : 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name : 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		//{ name : 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar' ] },
		{ name : 'insert', items : [ 'Image','YouTube','Table','HorizontalRule','Smiley','SpecialChar' ] },
		{ name : 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name : 'colors', items : [ 'TextColor','BGColor' ] },
		'/',
		{ name : 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name : 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name : 'styles', items : [ 'Styles','Format','Font','FontSize' ] }
	];

	config.toolbar = 'Simple';
	config.forcePasteAsPlainText = true;

	config.extraPlugins = 'youtube';

	/*
	config.extraPlugins = 'youtube';
	config.youtube_width = '640';
	config.youtube_height = '480';
	config.youtube_related = false;
	config.youtube_older = false;
	config.youtube_privacy = false;
	*/
	
	//config.extraPlugins = "youtube";

};
