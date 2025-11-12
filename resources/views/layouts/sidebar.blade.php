@section('styles')
    <style>
        .sidebar {
            width: 250px;
            background: #2c3e50;
            min-height: 100vh;
            color: white;
        }

        .sidebar h4 {
            padding: 20px 0;
            color: white;
        }

        .nav-link {
            color: #ecf0f1;
            padding: 12px 15px;
            display: block;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active {
            background: #d3d3d3;
            color: #2c3e50;
        }

        #content-area {
            padding: 20px;
            flex: 1;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
@endsection

<div style="display: flex;">
    <div class="sidebar">
        <h4 class="text-center mb-4">EduPanel</h4>
        <ul class="nav flex-column px-3">
            <li>
                <a class="nav-link" href="{{ route('dashboard') }}" data-url="{{ route('dashboard') }}">
                    <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('teacher.create') }}" data-url="{{ route('teacher.create') }}">
                    <i class="fa-solid fa-user-tie me-2"></i> Teachers
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('platform.create') }}" data-url="{{ route('platform.create') }}">
                    <i class="fa-solid fa-chalkboard me-2"></i> Platform
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('report.create') }}" data-url="{{ route('report.create') }}">
                    <i class="fa-solid fa-chart-line me-2"></i> Reports
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('setting.create') }}" data-url="{{ route('setting.create') }}">
                    <i class="fa-solid fa-gear me-2"></i> Settings
                </a>
            </li>
        </ul>
    </div>

    <div id="content-area">
        <div class="loading">Loading...</div>
    </div>
</div>

<script>
$(document).ready(function() {
    console.log('✅ AJAX navigation initialized');

    // ✅ Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ✅ Function to load content dynamically
    function loadPage(url, $link = null) {
        $('#content-area').html('<div class="loading">Loading...</div>');

        // 🔹 Clear all active states (on both <li> and <a>)
        $('.sidebar li, .sidebar .nav-link').removeClass('active');

        // 🔹 Highlight the clicked item (both <li> and <a>)
        if ($link) {
            $link.addClass('active');
            $link.closest('li').addClass('active');
        }

        $.ajax({
            url: url,
            type: 'GET',
            data: { ajax: 1 },
            dataType: 'html',
            success: function(response) {
                $('#content-area').html(response);

                // 🔹 Update the browser URL without reloading
                window.history.pushState({ path: url }, '', url);

                // 🔹 Re-run page scripts if defined
                if (typeof initPageScripts === 'function') {
                    initPageScripts();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#content-area').html('<div style="color:red;padding:20px;">Error loading content: ' + error + '</div>');
            }
        });
    }

    // ✅ Click event for all sidebar links
    $(document).on('click', '.nav-link', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        loadPage(url, $(this));
    });

    // ✅ Handle browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        loadPage(location.href);
    });

    // ✅ Highlight correct link on page load (refresh or direct visit)
    const currentUrl = window.location.href;
    let $activeLink = null;

    $('.nav-link').each(function() {
        const linkUrl = $(this).attr('href');
        if (currentUrl.includes(linkUrl)) {
            $(this).addClass('active');
            $(this).closest('li').addClass('active'); // highlight <li> too
            $activeLink = $(this);
        }
    });

    // ✅ Load the correct page on startup
    if ($activeLink) {
        loadPage($activeLink.data('url'), $activeLink);
    } else {
        const $defaultLink = $('.nav-link').first();
        $defaultLink.addClass('active');
        $defaultLink.closest('li').addClass('active');
        loadPage($defaultLink.data('url'), $defaultLink);
    }
});
</script>
@end
