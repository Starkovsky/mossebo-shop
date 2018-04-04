
// Rewrite current URL to HTTPS without reload page

if (location.protocol != 'https:')
{
    location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
}
