/**
 * Data set
 */
var items = new Array();
items.push({ 
    'name': 'Panda Sofas', 
    'descr': 'Panda Sofas approached me with a vision. They wanted a warm interior themed website with basic functions and they wanted it in time for their grand opening a week later. Total project completion time was 48 hours of grinding but it was well worth it.',
    'image': './images/projects/panda.png'
});
items.push({ 
    'name': 'Reinvigorate', 
    'descr': 'Reinvigorate measures your influence on the web in real-time. Gain up-to-the-minute insight into your audience, then adapt to meet their needs and watch your site grow.',
    'image': './images/projects/reinvigorate.png'
});
items.push({
    'name': 'Pulse',
    'descr': 'Pulse is the easy way to manage your cash flow online, allowing you to quickly manage and evaluate your income and expenses. Pulse empowers you to make decisions. While other accounting tools let you track your financials, they don\'t give you the ability to make the tough day to day decisions that happen when running a small business.',
    'image': './images/projects/pulse.png'
});
items.push({
    'name': 'Mobify',
    'descr': 'Mobile Web browsing is growing at an incredibly fast rate, with tens of billions page views shown on mobile every month. Mobile users are going to websites familiar to them, including yours! Some estimates put the share of mobile traffic at 20% for certain types of websites and it\'s growing.',
    'image': './images/projects/mobify.png'
});

/**
 * Action code
 */
$(document).ready(function() {
    // this is the current item, by array key
    var curIndex = 0;
    // how many items are in the list
    var max = items.length;

    // "previous" action
    $('.prev').click(function() {
        // decrement the curIndex
        curIndex--;
        if (curIndex < 0) {
            curIndex = max-1;
        }
        
        updateProject();
    });
        
    $('.next').click(function() {
        curIndex++;
        if (curIndex >= max) {
            curIndex = 0;
        }

        updateProject();
    });

    // update the latest project
    function updateProject() {
        $('#latest-project .preview .image').attr('src', items[curIndex]['image']);
        $('#latest-project .descr .title').html(items[curIndex]['name']);
        $('#latest-project .descr .description').html(items[curIndex]['descr']);
    }
});
