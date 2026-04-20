function setActiveSidebar(path) {
    $('.sb a.ni').removeClass('on');
    $('.sb a.ni').each(function () {
        var linkPath = new URL($(this).attr('href'), window.location.origin).pathname;
        if (linkPath === path) {
            $(this).addClass('on');
            return false; // break loop
        }
    });
}

// Helper update topbar
function updateTopbar($html) {
    var newPageTitle = $html.filter('meta[name="page-title"]').attr('content');
    var newPageSubtitle = $html.filter('meta[name="page-subtitle"]').attr('content');
    var newDocTitle = $html.filter('title').text();

    if (newPageTitle) $('[data-page-title]').text(newPageTitle);
    if (newPageSubtitle) $('[data-page-subtitle]').text(newPageSubtitle);
    if (newDocTitle) document.title = newDocTitle;
}

// Helper jalankan scripts di dalam #main-content
function evalPageScripts() {
    $('#main-content').each(function () {
        $.globalEval($(this).text());
        console.log($(this).text())
    });
}

// Helper load halaman via AJAX
function loadPage(url, pushState) {
    var $content = $('#main-content');

    $content.fadeTo(150, 0, function () {
        $.get(url, function (html) {
            var $html = $($.parseHTML(html, document, true));

            // Inject content + scripts sekaligus
            $content.html($html.find('#main-content').html());

            // Update sidebar & topbar
            setActiveSidebar(new URL(url, window.location.origin).pathname);
            updateTopbar($html);

            // Tambah history state
            if (pushState) {
                window.history.pushState({ url: url }, '', url);
            }

            $content.fadeTo(150, 1);

            // Jalankan scripts halaman baru
            evalPageScripts();

        }).fail(function () {
            // Fallback: full reload jika AJAX gagal
            window.location.href = url;
        });
    });
}