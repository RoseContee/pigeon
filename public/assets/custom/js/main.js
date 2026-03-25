function copyClipboard(that) {
    var value = that.data('link');
    if (!navigator.clipboard) {
        if (fallbackCopyTextToClipboard(value)) {
        }
    }
    navigator.clipboard.writeText(value).then(function() {
    }, function(err) {
    });
}