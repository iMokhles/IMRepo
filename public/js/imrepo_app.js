
var app = new Framework7({
    // App root element
    root: '#app',
    // App Name
    name: 'IMRepo',
    // App id
    id: 'com.imokhles.imrepo',
    // theme
    theme: 'ios',
    // Add default routes
    routes: [
        {
            path: '/depiction/:package_hash',
            url: "/depiction/{{package_hash}}"
        },
    ],
    // ... other parameters
});
app.on('formAjaxSuccess', function (formEl, data, xhr) {
    // do something with response data
    console.log('In formAjaxSuccess')
});
app.on('formAjaxComplete', function (formEl, data, xhr) {
    // do something with response data
    console.log('In formAjaxComplete: '+JSON.stringify(data))
});
app.on('formAjaxBeforeSend', function (formEl, data, xhr) {
    // do something with response data
    console.log('In formAjaxBeforeSend');
});
app.on('formAjaxError', function (formEl, data, xhr) {
    // do something with response data
    console.log('In formAjaxError: '+JSON.stringify(data));
});

var mainView = app.views.create('.view-main');
var searchbar = app.searchbar.create({
    el: '.searchbar',
    searchContainer: '.list',
    searchIn: '.item-title',
    on: {
        enable: function () {
            console.log('Searchbar enabled')
        },
        search(sb, query, previousQuery) {
            console.log(query, previousQuery);
        }
    }
})