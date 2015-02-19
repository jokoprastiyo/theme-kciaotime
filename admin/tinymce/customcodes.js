/*-----------------------------------------------------------------------------------*/
/* Button
/*-----------------------------------------------------------------------------------*/
(function() {  
    tinymce.create('tinymce.plugins.button', {  
        init : function(ed, url) {  
            ed.addButton('button', {  
                title : 'Add a button',  
                image : url+'/ui-button.png',  
                onclick : function() {  
                     ed.selection.setContent('[button color="red, blue, orange or green" url="" size="medium, small or default"]Button text[/button]');  
  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('button', tinymce.plugins.button);  
})();

/*-----------------------------------------------------------------------------------*/
/* Unordered lists
/*-----------------------------------------------------------------------------------*/
(function() {  
    tinymce.create('tinymce.plugins.list', {  
        init : function(ed, url) {  
            ed.addButton('list', {  
                title : 'Add stylized unordered list',  
                image : url+'/ui-list.png',  
                onclick : function() {  
                     ed.selection.setContent('[list type="arrow, square, plus, cross or check"]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/list]');  
  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('list', tinymce.plugins.list);  
})();

/*-----------------------------------------------------------------------------------*/
/* Tabs
/*-----------------------------------------------------------------------------------*/
(function() {  
    tinymce.create('tinymce.plugins.tabs', {  
        init : function(ed, url) {  
            ed.addButton('tabs', {  
                title : 'Add tabs',  
                image : url+'/ui-tabs.png',  
                onclick : function() {  
                     ed.selection.setContent('[tabs tab1=\"Tab 1\" tab2=\"Tab 2\" tab3=\"Tab 3\"]<br /><br />[tab]Tab content 1[/tab]<br />[tab]Tab content 2[/tab]<br />[tab]Tab content 3[/tab]<br /><br />[/tabs]');  
  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('tabs', tinymce.plugins.tabs);  
})();

/*-----------------------------------------------------------------------------------*/
/* Accordion
/*-----------------------------------------------------------------------------------*/
(function() {  
    tinymce.create('tinymce.plugins.accordion', {  
        init : function(ed, url) {  
            ed.addButton('accordion', {  
                title : 'Add an accordion',  
                image : url+'/ui-accordion.png',  
                onclick : function() {  
                     ed.selection.setContent('[accordion]<br /><br />[pane title=\"Pane 1\"]Pane content #1[/pane]<br />[pane title=\"Pane 1\"]Pane content #1[/pane]<br />[pane title=\"Pane 1\"]Pane content #1[/pane]<br /><br />[/accordion]');  
  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('accordion', tinymce.plugins.accordion);  
})();
