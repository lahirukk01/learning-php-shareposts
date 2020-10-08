const pageName = document.getElementById('page-name').value
// console.log(pageName)

switch (pageName) {
    case 'login':
        $('#li-login').addClass('active')
        break
    case 'register':
        $('#li-register').addClass('active')
        break
    case 'home':
        $('#li-home').addClass('active')
        break
    case 'about':
        $('#li-about').addClass('active')
        break
}