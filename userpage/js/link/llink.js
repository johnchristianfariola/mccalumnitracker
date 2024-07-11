document.addEventListener('DOMContentLoaded', function () {
    var path = window.location.pathname;
    var page = path.split("/").pop();

    // Remove 'active' class from all links
    document.querySelectorAll('.nav-tabs li').forEach(function (element) {
        element.classList.remove('active');
    });

    // Add 'active' class to the current link
    switch(page) {
        case 'index.php':
            document.getElementById('home').classList.add('active');
            break;
        case 'view_news.php':
        case 'visit_news.php':
            document.getElementById('news').classList.add('active');
            break;
        case 'event_view.php':
            document.getElementById('event').classList.add('active');
            break;
        case 'jobs.php':
            document.getElementById('job').classList.add('active');
            break;
        case 'forum.php':
            document.getElementById('forum').classList.add('active');
            break;
        case 'gallery.php':
            document.getElementById('gallery').classList.add('active');
            break;
        default:
            document.getElementById('home').classList.add('active');
    }
});