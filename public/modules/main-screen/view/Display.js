/*
 * @author xerox
 */
Ext.define(
    'Lcars.MainScreen.view.Display',
    {
        extend: 'Ext.panel.Panel',
        alias: ['widget.main-display'],
        
        layout: 'fit',
        bodyCls: 'background',
        title: 'Mainscreen',
        
        items: [
            {
                border: false,
                bodyCls: 'background',
                html: 'LCARS'
            }]
    }
);
