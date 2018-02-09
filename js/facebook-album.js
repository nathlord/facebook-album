var jsEmbed = document.createElement("script");
jsEmbed.id = "FacebookAlbumIFrame", jsEmbed.src = "js/iframe.js", document.getElementsByTagName("body")[0].appendChild(jsEmbed)

EMBEDSOCIAL = {
    getEmbedData : function(albumRef, albumDiv) {
        var iframes = albumDiv.getElementsByTagName('iframe');
        if (iframes.length <= 0) {
            var ifrm = document.createElement("iframe");
            var srcIfrm = "index.php?albumid="+albumRef;
            ifrm.setAttribute("src", srcIfrm);
            ifrm.setAttribute("id", 'embedIFrame_' + albumRef);
           // ifrm.setAttribute("id", 'embedIFrame_' + albumRef+Math.random().toString(36).substring(7));
            ifrm.style.width = "100%";
            // ifrm.style.height = "100%";
            ifrm.style.border = "0";
            ifrm.setAttribute("scrolling", "no");
            albumDiv.appendChild(ifrm);
            EMBEDSOCIAL.initResizeFrame();
        }
    },
    initResizeFrame : function() {
        var siteUrl = window.location.href;


        if (document.getElementById("FacebookAlbumIFrame") && "function" === typeof iFrameResize) {
            iFrameResize ();
        } else {
            setTimeout(EMBEDSOCIAL.initResizeFrame, 200);
        }
    }
}

var embedsocialAlbums = document.getElementsByClassName("facebook-album");
var embedsocialAlbumsRef = [];
for (i = 0; i < embedsocialAlbums.length; i++) {
    var embedsocialAlbumRef = embedsocialAlbums[i].getAttribute("data-ref");
    EMBEDSOCIAL.getEmbedData(embedsocialAlbumRef, embedsocialAlbums[i]);
} 