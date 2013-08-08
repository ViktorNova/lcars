Ext.define(
    'Lcars.view.Viewport',
    {
        extend: 'Ext.container.Viewport',
        layout: 'border',
        padding: 20,
        
        defaults: {
            collapsible: true,
            split: true,
            bodyPadding: 20
        },
        
        items: [
            {
                xtype: 'main-display',
                collapsible: false,
                margin: '0 0 0 3',
                region: 'center'
            },
            {
                xtype: 'main-navigation',
                region: 'west'
            }]
    }
);
