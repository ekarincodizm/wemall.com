function UrlToLang(url){
    if(url != undefined){
        if(LANG != 'th'){
            url = "/" + LANG + url;
        }
        return url;
    }
    return "";
}