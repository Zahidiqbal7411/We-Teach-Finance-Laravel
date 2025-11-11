

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
        
        .nav-link i {
            width: 20px;
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

{{-- <div class="sidebar">
    <h4 class="text-center mb-4">EduPanel</h4>
    <ul class="nav flex-column px-3">
      <li><a class="nav-link " href="{{route('dashboard')}}"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a></li>
      <li><a class="nav-link" href="{{route('teacher.create')}}"><i class="fa-solid fa-user-tie me-2"></i> Teachers</a></li>
      <li><a class="nav-link" href="{{route('platform.create')}}"><i class="fa-solid fa-chalkboard me-2"></i> Platform</a></li>
      <li><a class="nav-link" href="{{route('report.create')}}"><i class="fa-solid fa-chart-line me-2"></i> Reports</a></li>
      <li><a class="nav-link" href="{{route('setting.create')}}"><i class="fa-solid fa-gear me-2"></i> Settings</a></li>
    </ul>
  </div> --}}

 <div style="display: flex;">
        <div class="sidebar">
            <h4 class="text-center mb-4">EduPanel</h4>
            <ul class="nav flex-column px-3">
                <li>
                    <a class="nav-link" href="{{route('dashboard')}}" data-url="{{route('dashboard')}}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('teacher.create')}}" data-url="{{route('teacher.create')}}">
                        <i class="fa-solid fa-user-tie me-2"></i> Teachers
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('platform.create')}}" data-url="{{route('platform.create')}}">
                        <i class="fa-solid fa-chalkboard me-2"></i> Platform
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('report.create')}}" data-url="{{route('report.create')}}">
                        <i class="fa-solid fa-chart-line me-2"></i> Reports
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('setting.create')}}" data-url="{{route('setting.create')}}">
                        <i class="fa-solid fa-gear me-2"></i> Settings
                    </a>
                </li>
            </ul>
        </div>
        
        <div id="content-area">
            <!-- Content will be loaded here -->
        </div>
    </div>
 <script>
        $(document).ready(function() {
            console.log('Script loaded successfully');
            
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle navigation clicks
            $('.nav-link').on('click', function(e) {
                e.preventDefault();
                console.log('Link clicked!');
                
                const url = $(this).data('url') || $(this).attr('href');
                console.log('URL:', url);
                const $link = $(this);
                
                // Remove active class from all links
                $('.nav-link').removeClass('active');
                
                // Add active class to clicked link
                $link.addClass('active');
                console.log('Active class added');
                
                // Show loading indicator
                $('#content-area').html('<div class="loading">Loading...</div>');
                
                // Make AJAX request with ajax parameter
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { ajax: 1 }, // Send ajax flag
                    dataType: 'html',
                    success: function(response) {
                        console.log('Success! Response received');
                        $('#content-area').html(response);
                        
                        // Update browser URL without reload
                        window.history.pushState({path: url}, '', url);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        console.error('Response:', xhr.responseText);
                        $('#content-area').html('<div style="color: red; padding: 20px;">Error loading content: ' + error + '<br>Status: ' + status + '</div>');
                    }
                });
            });
            
            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                location.reload();
            });
            
            // Set active link on page load based on current URL
            const currentPath = window.location.pathname;
            $('.nav-link').each(function() {
                if ($(this).attr('href') === currentPath) {
                    $(this).addClass('active');
                }
            });
            
            console.log('Number of nav links found:', $('.nav-link').length);
        });
    </script>

