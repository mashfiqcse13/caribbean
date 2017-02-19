/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

var val = new Array;

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here.
    // For the complete reference:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config

    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
        /*{ name: 'links' },*/
        {name: 'insert'},
        {name: 'forms'},
        {name: 'tools'},
        /*{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },*/
        {name: 'others'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align']},
        {name: 'styles'},
        {name: 'colors'},
        {name: 'about'}
    ];

    // Remove some buttons, provided by the standard plugins, which we don't
    // need to have in the Standard(s) toolbar.
    config.removeButtons = 'Underline,Subscript,Superscript';

    // Se the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre';

    // Make dialogs simpler.
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.extraPlugins = 'image';
    
    
    config.extraPlugins = 'myplugin,anotherplugin';
    

    //My Plugin Purchased image upload
    config.extraPlugins = 'doksoft_image,wordcount';
    config.toolbar_name = [['doksoft_image']];



    /*console.log(val = ((location.href).split('?')[0]).split('/'));
     console.log(val);*/
    val = ((location.href).split('?')[0]).split('/');
    //console.log(val);
    if (inArray(inArray("add-topic-reply.php", val) || inArray("add-forum-topic.php", val) || inArray("edit-forum-topic.php", val) || "edit-forum-topic-admin.php", val) || inArray("add-topic-reply-admin.php", val) || inArray("edit-forum-topic-reply-admin.php", val) || inArray("add-forum-topic-admin.php", val))
    {
        config.wordcount = {
            // Whether or not you want to show the Word Count
            showWordCount: true,
            // Whether or not you want to show the Char Count
            showCharCount: true,
            charLimit: 350
        };

        config.doksoft_uploader_url = '../ckeditor/plugins/doksoft_uploader/uploader.php?resize=y';
    } else
    {
        config.doksoft_uploader_url = '../ckeditor/plugins/doksoft_uploader/uploader.php?resize=n';
    }

};

function inArray(needle, haystack) {
    var length = haystack.length;
    for (var i = 0; i < length; i++) {
        if (haystack[i] == needle)
            return true;
    }
    return false;
}