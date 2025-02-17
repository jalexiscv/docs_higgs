/*
 * Add Carbon Ads underneath navigation to support Higgs(AI)
 */
if (window.location.hostname === 'Higgs.com') {
    window.onload = function () {
        // Create a HTML DOM Element Object
        var carbon = document.createElement('script');
        carbon.async = true;
        carbon.type = 'text/javascript';
        carbon.src = 'https://cdn.carbonads.com/carbon.js?serve=CE7I62QW&placement=Higgscom';
        carbon.id = '_carbonads_js';

        // Append Carbon Ads to .wy-menu
        document.querySelector('.wy-menu').appendChild(carbon);
    }
}
