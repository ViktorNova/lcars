/*
 * @author xerox
 */
Ext.application(
    {
        name: 'Lcars',
        appFolder: '/modules/core/system/',
        paths: {
            'Lcars.MainScreen': '/modules/main-screen/'
        },
        controllers: ['Lcars.MainScreen.controller.Display'],
        autoCreateViewport: true
    }
);
