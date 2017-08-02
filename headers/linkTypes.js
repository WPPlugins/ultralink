var linkTypes =
// BASELINKTYPES
{
    "Meta":
    {  "order": "-1000", "categoryType": "meta",
        "links":
        {
            "ultralinkme": { "name": "Ultralink", "pane": "true", "w": "600", "h": "400", "viewType": "light", "icon": "icon.png", "iconShrinkage": "0.7", "suppliesAuth": "true" },
            "unknown": { "name": "Unknown" }
        }
    },
    "Image":
    { "order": "-1000", "categoryType": "image",
        "links":
        {
            "image": { "name": "Image", "detectors": ["(\\.png|\\.jpeg|\\.jpg|\\.gif|\\.tiff|\\.svg|\\.bmp)$", "http.*gravatar\\.com/avatar/"] }
        }
    },
    "Links":
    { "order": "-1000",
        "links":
        {
            "href":  { "name": "Link", "view": "true", "h": "500" },
            "href2": { "name": "Link 2" },
            "href3": { "name": "Link 3" }
        }
    },
    "App":
    {
        "links":
        {
            "appios":     { "name": "iOS App",     "icon": "icon.svg" },
            "appmac":     { "name": "Mac App",     "icon": "icon.svg" },
            "appwebos":   { "name": "webOS App", "detectors": ["http.*developer\\.palm\\.com/appredirect"] },
            "appandroid": { "name": "Android App", "icon": "icon.svg", "detectors": ["http.*play\\.google\\.com/store/apps/details"] },
            "appwindows": { "name": "Windows App", "icon": "icon.svg", "iconShrinkage": "0.6" }
        }
    },
    "Buy":
    {
        "links":
        {
            "buy":               { "name": "Buy", "detectors": ["https?://click\\.linksynergy\\.com"] },
            "buyamazon":         { "name": "Buy", "affiliateTag": "tag",    "message": "true", "auth": "ultralinkme", "detectors": ["http.*www\\.amazon\\.(br|ca|com|co\\.uk|cn|de|es|fr|in|it|jp)/"], "view": "true" },
            "buyapple":          { "name": "Buy", "affiliateTag": "id",     "icon": "icon.svg", "detectors": ["http.*itunes\\.apple\\.com"] },
            "buyebay":           { "name": "Buy", "affiliateTag": "campid", "icon": "icon.svg", "detectors": ["http.*ebay\\.com"] }
        }
    },
    "Social":
    {
        "links":
        {
            "twitter":    { "name": "Twitter",  "view": "true", "message": "true", "insights": "true", "suppliesAuth": "true", "endpointDomain": "api.twitter.com", "auth": "twitter", "authType": "oauth1", "icon": "icon.svg", "iconShrinkage": "0.65", "detectors": ["http.*twitter\\.com"]  },
            "googleplus": { "name": "Google+",  "view": "true", "message": "true", "suppliesAuth": "true", "endpointDomain": "googleapis.com/plus", "auth": "googleplus", "icon": "icon.svg", "iconShrinkage": "0.65", "detectors": ["http.*plus\\.google\\.com"] },
            "linkedin":   { "name": "LinkedIn",                 "message": "true", "insights": "true", "endpointDomain": "api.linkedin.com", "iconShrinkage": "0.65", "detectors": ["http.*linkedin\\.com"] },
            "facebook":   { "name": "Facebook",                 "message": "true", "endpointDomain": "graph.facebook.com","icon": "icon.svg", "iconShrinkage": "0.65", "detectors": ["http.*facebook\\.com"] }
        }
    },
    "Reference":
    {
        "links":
        {
            "wikipedia":  { "name": "Wikipedia",     "pane": "true", "message": "true", "view": "true", "h": "300", "autoPop": "true", "icon": "icon.svg", "detectors": ["http.*wikipedia\\.org/wiki/(?!(User|Wikipedia|File|MediaWiki|Template|Help|Category|Portal|Book|Education_Program|TimedText)(_talk)?:)"] },
            "mediawiki":  { "name": "MediaWiki",     "pane": "true", "view": "true", "h": "300", "icon": "icon.svg" },
            "mapgoogle":  { "name": "Google Map",    "pane": "true", "view": "true", "iconShrinkage": "0.65", "detectors": ["http.*maps\\.google\\.com"], "h": "500" },
            "comicvine":  { "name": "Comic Vine",    "pane": "true", "message": "true", "auth": "ultralinkme", "view": "true", "autoPop": "true", "detectors": ["http.*comicvine\\.com/"] },
            "intelark":   { "name": "Intel ARK",     "pane": "true", "view": "true", "message": "true", "auth": "ultralinkme", "autoPop": "true", "icon": "icon.svg", "detectors": ["http.*ark\\.intel\\.com/products\/"] },
            "angellist":  { "name": "AngelList",     "view": "true", "message": "true", "insights": "true", "suppliesAuth": "true", "endpointDomain": "api.angel.co", "auth": "angellist", "icon": "icon.svg", "iconShrinkage": "0.7", "detectors": ["http.*angel\\.co"] },
            "crunchbase": { "name": "CrunchBase",    "view": "true", "message": "true", "insights": "true", "detectors": ["http.*crunchbase\\.com/(company|person|organization)"] },
            "webmd":      { "name": "WebMD",         "view": "true", "message": "true", "detectors": ["http.*webmd\\.com/"], "h": "300" },
            "pdf":        { "name": "PDF",           "view": "true", "detectors": ["(\\.pdf)$"], "h": "600" },
            "imdb":       { "name": "IMDB",          "icon": "icon.svg", "detectors": ["http.*www\\.imdb\\.com"] },
            "freebase":   { "name": "Freebase",      "detectors": ["http.*freebase\\.com"] },
            "manpage":    { "name": "Documentation", "detectors": ["http.*developer\\.apple\\.com.*/Manpages/", "http.*opengl\\.org.*/docs/man/"] },
            "espn":       { "name": "ESPN", "icon": "icon.svg" },
            "github":     { "name": "GitHub",        "detectors": ["http.*github\\.com"] },
            "map":        { "name": "Map" }
        }
    },
    "Video":
    {
        "links":
        {
            "video":        { "name": "Video"   },
            "videoyoutube": { "name": "YouTube", "pane": "true", "view": "true", "h": "375", "detectors": ["http.*youtube\\.com"] },
            "videovimeo":   { "name": "Vimeo",   "pane": "true", "view": "true", "h": "375", "detectors": ["http.*vimeo\\.com"] },
            "videovlc":     { "name": "VLC",     "pane": "true", "view": "true", "h": "375" }
        }
    },
    "Annotation":
    {
        "links":
        {
            "annotation": { "name": "Annotation", "pane": "true", "view": "true", "message": "true", "detectors": ["http.*ultralink\\.me/annotation/"] }
        }
    },
    "Contact":
    {
        "links":
        {
            "email": { "name": "Email",  "detectors": ["mailto:.*"], "newWindowSuppress": "true" },
            "xmpp":  { "name": "Jabber", "detectors": ["xmpp:.*"], "view": "true", "auth": "xmpp", "authType": "xmpp", "message": "true", "icon": "icon.svg", "suppliesAuth": "true" },
            "slack": { "name": "Slack",  "detectors": ["http.*slack\\.com"] }
        }
    },
    "Bookmarks":
    { "categoryType": "drawer",
        "links":
        {
            "bookmark": { "name": "Bookmarks", "pane": "true", "view": "true", "h": "500", "iconBackground": "false" },
            "app":      { "name": "Apps",      "pane": "true", "view": "true", "h": "500" }
        }
    },
    "Search":
    { "order": "1000",
        "links":
        {
            "searchul":     { "name": "Search Ultralinks", "pane": "true", "w": "530", "h": "457", "viewType": "light" },
            "search":       { "name": "Search" },
            "searchgoogle": { "name": "Google Search",     "view": "true", "message": "true", "quote": "false", "prefix": "https://www.google.com/search?q=", "detectors": ["http.*google\\.com/search\\?"] },
            "searchbing":   { "name": "Bing Search",       "view": "true", "message": "true", "quote": "false", "prefix": "https://www.bing.com/search?q=", "detectors": ["http.*bing\\.com/search\\?"] },
            "searchyahoo":  { "name": "Yahoo Search",      "quote": "false", "icon": "icon.svg", "prefix": "https://search.yahoo.com/search?p=", "detectors": ["http.*search\\.yahoo\\.com/search\\?"] },
            "searchpubmed": { "name": "PubMed Search",     "pane": "true", "quote": "false", "icon": "icon.svg", "prefix": "https://www.ncbi.nlm.nih.gov/pubmed/?term=", "w": "824", "h": "600" }
        }
    }
}
// BASELINKTYPES
;

var orderedCategories = [];

function doOrderedCategories()
{
    orderedCategories = [];

    for( var cat in linkTypes ){ orderedCategories.push( cat ); }

    orderedCategories.sort( function( a, b )
    {
        var aVal = 0; if( linkTypes[a]["order"] != undefined ){ aVal = parseInt(linkTypes[a]["order"]); }
        var bVal = 0; if( linkTypes[b]["order"] != undefined ){ bVal = parseInt(linkTypes[b]["order"]); }
        return aVal - bVal;
    } );
}
doOrderedCategories();

function categoryNumber( tcat ){ for( var n = 0; n < orderedCategories.length; n++ ){ if( orderedCategories[n] == tcat ){ break; } } return n; }

function mergeLinkTypes( customLinkTypes, resourceLocation )
{
    for( var ccat in customLinkTypes )
    {
        var customLinkCat = customLinkTypes[ccat];

        var existingLinkCat = linkTypes[ccat];
        if( existingLinkCat )
        {
            if( customLinkCat['order'] ){ existingLinkCat['order'] = customLinkCat['order']; }

            for( var itype in customLinkCat.links )
            {
                var customLinkType = customLinkCat.links[itype];

                var existingLinkType = existingLinkCat.links[itype];
                if( existingLinkType )
                {
                    for( var setting in customLinkType )
                    {
                        updateLinkType( itype, setting, customLinkType[setting] );
                    }
                }
                else
                {
                    existingLinkCat.links[itype] = customLinkType;
                    if( resourceLocation ){ updateLinkType( itype, "resourceLocation", resourceLocation ); }
                }
            }
        }
        else
        {
            linkTypes[ccat] = customLinkCat;

            if( resourceLocation )
            {
                for( var itype in customLinkCat.links )
                {
                    updateLinkType( itype, "resourceLocation", resourceLocation );
                }
            }
        }
    }

    doOrderedCategories();
}

function linkTypeCondition( cond )
{
    for( var cat in linkTypes )
    {
        for( var linkType in linkTypes[cat].links )
        {
            var result = cond( cat, linkType, linkTypes[cat].links[linkType] );
            if( result != undefined ){ return result; }
        }
    }

    return undefined;
}

function getLinkType( ltype )
{
    var lt = linkTypeCondition( function( cat, type, link )
    {
        if( ltype == type ){ return link; }
    } );

//    if( lt == undefined )
//    {
//        console.log( "No link type " + ltype  + " currently loaded." );
//    }

    return lt;
}

function updateLinkType( ltype, key, value )
{
    var linkType = getLinkType( ltype, key, value );
    linkType[key] = value;
}

function detectLinkType( URL )
{
    var result = linkTypeCondition( function( cat, type, link )
    {
        if( link.detectors )
        {
            for( var d = 0; d < link.detectors.length; d++ )
            {
                var detector = link.detectors[d];
                if( URL.match(RegExp(detector, "i")) ){ return type; }
            }
        }
    } );

    if( result == undefined ){ result = 'href'; }

    return result;
}

function updateRoots( roots, callback, failureCallback )
{
    var combinedOptions = {};

    if( roots.length == 0 )
    {
        if( callback ){ callback(); }
    }
    else
    {
        var cr = 0;
        for( var r = 0; r < roots.length; r++ )
        {
            var root = roots[r];

            var rootPath = root + "options.json";

            jQuery.get( rootPath, function( data )
            {
                if( data != "" )
                {
                    var options = "";

                    try{ options = JSON.parse( data ); }
                    catch(e){ if( failureCallback ){ failureCallback( rootPath, "Is not valid JSON." ); } }

                    if( options != "" )
                    {
                        combinedOptions[root] = options;

                        if( options['customLinkTypes'] )
                        {
                            mergeLinkTypes( options['customLinkTypes'], root );
                        }
                    }
                }
                else if( failureCallback ){ failureCallback( rootPath, "File is empty." ); }

                cr++; if( cr == roots.length ){ if( callback ){ callback( combinedOptions ); } }

            }, 'text').fail( function()
            {
                if( failureCallback ){ failureCallback( rootPath, "Could not access." ); }

                cr++; if( cr == roots.length ){ if( callback ){ callback( combinedOptions ); } }
            });


//            jQuery.getJSON( root + "options.json", function( options )
//            {
//                if( options['customLinkTypes'] )
//                {
//                    mergeLinkTypes( options['customLinkTypes'], root );
//                }
//
//                cr++;
//
//                if( cr == roots.length )
//                {
//                    if( callback ){ callback( options ); }
//                }
//            }).fail( function()
//            {
//                if( failureCallback ){ failureCallback(); }
//            });
        }
    }
}

function linkImageSize( fSize )
{
    var imgSize = 256;

    var adjustedFSize = fSize * 2;

         if( adjustedFSize <=  16 ){ imgSize =  16; }
    else if( adjustedFSize <=  32 ){ imgSize =  32; }
    else if( adjustedFSize <=  64 ){ imgSize =  64; }
    else if( adjustedFSize <= 128 ){ imgSize = 128; }

    return imgSize;
}

function shadowBox( shadowColor, size )
{
    switch( shadowColor )
    {
        case 'blue':  { return "0 0px " + (size * roundingRatio) + "px rgb(  0,  0, 192)"; } break;
        case 'black': { return "0 0px " + (size * roundingRatio) + "px rgb( 30, 30,  30)"; } break;
             default: { return "0 2px 2px rgba( 0, 0, 0, 0.3 )";                           }
    }
}

var roundingRatio = 0.17742;

function linkTypeImageDiv( base, type, size, shadowColor, rounded )
{
    var lt = getLinkType( type ); if( !lt ){ lt = getLinkType("unknown"); }

    var imageSize = linkImageSize( size );

    var linkTypeImageDiv = jQuery("<div>", { 'data-type': type, 'data-size': size }).css({ 'position': "relative", 'width': size + "px", 'max-height': size + "px", 'vertical-align': "middle", 'height': "100%" });

    var theIconImageURL = base;
    if( ((type != 'image') || ((type == 'image') && (base == masterPath))) )
    {
        if( lt["resourceLocation"] ){ theIconImageURL = lt["resourceLocation"]; }
        theIconImageURL += 'linkTypes/' + type.replace(RegExp("[0-9]$", "g"), "") + '/icon/';
        if( lt["icon"] ){ theIconImageURL += lt["icon"]; }else{ theIconImageURL += imageSize + '.png'; }
    }

    var theIconImage = jQuery('<img>', { 'src': theIconImageURL }).css({ 'width': size + "px", 'height': size + "px" });

    if( (lt["iconBackground"] != 'false') && ((type != 'image') || ((type == 'image') && (base == masterPath))) )
    {
        var theIconBackground = jQuery('<img>', {'src': base + 'ultralinkImages/iconBackground' + imageSize + '.png' }).css({ 'width': size + "px", 'height': size + "px", 'border-radius': (size * .17742) + "px" });

        if( rounded != false ){ theIconBackground.css({ 'border-radius': (size * roundingRatio) + "px" }); }
        theIconBackground.css({ 'box-shadow': shadowBox( shadowColor, size ) });

        linkTypeImageDiv.append( theIconBackground );

        var iconShrinkage = 0.75; if( lt["iconShrinkage"] ){ iconShrinkage = parseFloat( lt["iconShrinkage"] ); }
        var iconAdjustX   = 0.0;  if( lt["iconAdjustX"]   ){ iconAdjustX   = parseFloat( lt["iconAdjustX"]   ); }
        var iconAdjustY   = 0.0;  if( lt["iconAdjustY"]   ){ iconAdjustY   = parseFloat( lt["iconAdjustY"]   ); }

        var shrinkBugAdjust = 17 - size; if( shrinkBugAdjust < 0 ){ shrinkBugAdjust = 0; }

        theIconImage.css({ 'top': (iconAdjustY * size) + shrinkBugAdjust + "px", 'left': (iconAdjustX * size) + "px", 'position': "absolute", 'transform': "scale(" + iconShrinkage + ", " + iconShrinkage +  ")" });
    }
    else
    {
        if( type == 'image' ){ theIconImage.css({ 'width': "", 'height': "", 'max-width': size + "px", 'max-height': size + "px" }); }

        if( rounded != false )
        {
            theIconImage.css({ 'border-radius': (size * roundingRatio) + "px" });
            theIconImage.css({ 'box-shadow': shadowBox( shadowColor, size ) });
        }
    }

    linkTypeImageDiv.append( theIconImage );

    return linkTypeImageDiv;
}

function changeLinkTypeImageShadowColor( linkTypeImageDiv, shadowColor )
{
    jQuery( "img", linkTypeImageDiv ).first().css({ 'box-shadow': shadowBox( shadowColor, linkTypeImageDiv.attr('data-size') ) });
}

var lt = {};
lt.linkTypes           = linkTypes;
lt.orderedCategories   = orderedCategories;
lt.doOrderedCategories = doOrderedCategories;
lt.categoryNumber      = categoryNumber;
lt.mergeLinkTypes      = mergeLinkTypes;
lt.linkTypeCondition   = linkTypeCondition;
lt.getLinkType         = getLinkType;
lt.updateLinkType      = updateLinkType;
lt.detectLinkType      = detectLinkType;
lt.linkTypeImageDiv    = linkTypeImageDiv;
