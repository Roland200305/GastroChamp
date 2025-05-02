function showContent(contentType) {
    const container = document.getElementById('content-container');
    const allContents = document.querySelectorAll('.content-box');
    
    allContents.forEach(content => {
        content.style.display = 'none';
    });
    
    container.style.display = 'block';
    document.getElementById(contentType + '-content').style.display = 'block';
}