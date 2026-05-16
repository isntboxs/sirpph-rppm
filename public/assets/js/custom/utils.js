function setActiveSidebar(path) {
    $('.sb a.ni').removeClass('on');
    $('.sb a.ni').each(function () {
        var linkPath = new URL($(this).attr('href'), window.location.origin).pathname;
        if (linkPath === path) {
            $(this).addClass('on');
            return false;
        }
    });
}

function updateTopbar($html) {
    var newPageTitle = $html.filter('meta[name="page-title"]').attr('content');
    var newPageSubtitle = $html.filter('meta[name="page-subtitle"]').attr('content');
    var newDocTitle = $html.filter('title').text();

    if (newPageTitle) $('[data-page-title]').text(newPageTitle);
    if (newPageSubtitle) $('[data-page-subtitle]').text(newPageSubtitle);
    if (newDocTitle) document.title = newDocTitle;
}

function evalPageScripts() {
    $('#main-content').each(function () {
        $.globalEval($(this).text());
        console.log($(this).text())
    });
}