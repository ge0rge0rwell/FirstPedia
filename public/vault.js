jQuery(document).ready(function($) {
    let currentPage = 1;
    let maxPages = 999; 
    let darkMode = localStorage.getItem('fkv_dark_mode') === 'true';

    function init() {
        if(darkMode) $('body').addClass('fkv-dark');
        updateIcon();
    }

    function updateIcon() {
        $('#fkv-mode-toggle').text(darkMode ? '☀️' : '🌙');
    }

    // Toggle Dark Mode
    $('#fkv-mode-toggle').on('click', function() {
        darkMode = !darkMode;
        $('body').toggleClass('fkv-dark');
        localStorage.setItem('fkv_dark_mode', darkMode);
        updateIcon();
    });

    // Fetch Posts
    function fetchPosts(page = 1, append = false) {
        let filters = {};
        $('.fkv-filter-select').each(function() {
            filters[$(this).data('tax')] = $(this).val();
        });

        let search = $('#fkv-search-input').val();

        $.ajax({
            url: fkvData.ajax_url,
            type: 'POST',
            data: {
                action: 'fkv_search',
                nonce: fkvData.nonce,
                paged: page,
                search: search,
                ...filters
            },
            beforeSend: function() {
                if(!append) $('#fkv-grid').addClass('loading');
                $('#fkv-load-more').text('Loading...');
            },
            success: function(res) {
                if(res.success) {
                    if(append) {
                        $('#fkv-grid').append(res.data.html);
                    } else {
                        $('#fkv-grid').html(res.data.html);
                    }
                    maxPages = res.data.max_pages;
                    currentPage = page;
                    
                    if(currentPage >= maxPages) {
                        $('#fkv-load-more').hide();
                    } else {
                        $('#fkv-load-more').show().text('Load More');
                    }
                }
            },
            complete: function() {
                 $('#fkv-grid').removeClass('loading');
            }
        });
    }

    // Events
    $('#fkv-search-input').on('keyup', _.debounce(function() {
        fetchPosts(1, false);
    }, 500));

    $('.fkv-filter-select').on('change', function() {
        fetchPosts(1, false);
    });

    $('#fkv-reset-btn').on('click', function() {
        $('#fkv-search-input').val('');
        $('.fkv-filter-select').val('');
        fetchPosts(1, false);
    });

    $('#fkv-load-more').on('click', function() {
        fetchPosts(currentPage + 1, true);
    });

    // PDF Modal
    $(document).on('click', '.fkv-btn-view', function(e) {
        e.preventDefault();
        let url = $(this).data('pdf');
        let title = $(this).data('title');
        
        $('#fkv-modal-title').text(title);
        $('#fkv-modal-frame').attr('src', url);
        $('#fkv-modal').fadeIn();
    });

    $('.fkv-close').on('click', function() {
        $('#fkv-modal').fadeOut();
        $('#fkv-modal-frame').attr('src', '');
    });

    $(window).on('click', function(e) {
        if ($(e.target).is('#fkv-modal')) {
            $('#fkv-modal').fadeOut();
            $('#fkv-modal-frame').attr('src', '');
        }
    });

    // Underscore debounce polyfill if not present (simple version)
    if (typeof _ === 'undefined') {
        window._ = {
            debounce: function(func, wait, immediate) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            }
        };
    }

    init();
});
