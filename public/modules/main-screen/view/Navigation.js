/*
 * @author xerox
 */
Ext.define(
    'Lcars.MainScreen.view.Navigation',
    {
        extend: 'Ext.panel.Panel',
        alias: ['widget.main-navigation'],
        
        bodyCls: 'background',
        title: 'Nav',
        
        defaults: {
            scale: 'large',
            width: '100%',
            margin: '0 0 10 0',
            textAlign: 'left'
        },
        
        items: [
            {
                xtype: 'button',
                text: 'Test'
            },
            {
                xtype: 'button',
                text: 'Test 2'
            }]
    }
);
