document.querySelectorAll('#hq-snippet-reservation-button').forEach(item => {
    item.addEventListener('click', event => {
        //handle click
        var brand = item.dataset.brand;
        var snippet = item.dataset.snippet;
        var code = hqBrandSnippets[brand][snippet];
        navigator.permissions.query({ name: 'clipboard-write' }).then(result => {
            if (result.state == 'granted' || result.state == 'prompt') {
                navigator.clipboard.writeText(code).then(function() {
                    // feedback
                    //copied
                    alert('Snippet Copied!!!');
                }, function() {
                    alert("There was an issue copying the snippet. Please get in contact with out support team");
                });
            }
        });
    });
});
(function($){
    tippy('#hq-snippet-reservation-button');
})(jQuery);
