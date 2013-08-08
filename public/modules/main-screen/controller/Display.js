/*
 * @author xerox
 */
Ext.define(
    'Lcars.MainScreen.controller.Display',
    {
        extend: 'Ext.app.Controller',
        
        views: ['Navigation', 'Display'],
        
        init: function() {
            this.control(
                {
                    'viewport > panel': {
                        render: this.onPanelRendered
                    }
                }
            );
        },
        
        onPanelRendered: function() {
            console.log('The panel was rendered');
        }
    }
);
