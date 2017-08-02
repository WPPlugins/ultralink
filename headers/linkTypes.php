<?php

    $linkTypes = json_decode( file_get_contents( dirname(__FILE__) . '/linkTypes.json' ), true );

    $orderedCategories = array();

    function catOrder($a, $b)
    {
        $aVal = 0; if( !empty($linkTypes[$a]["order"]) ){ $aVal = intval($linkTypes[$a]["order"]); }
        $bVal = 0; if( !empty($linkTypes[$b]["order"]) ){ $bVal = intval($linkTypes[$b]["order"]); }
        return $aVal - $bVal;
    }

    function doOrderedCategories()
    {
        global $linkTypes;
        global $orderedCategories;

        $orderedCategories = array();

        if( !empty($linkTypes) )
        {
            foreach( $linkTypes as $cat => $val ){ array_push( $orderedCategories, $cat ); }
        }

        uasort($orderedCategories, "catOrder");
    }
    doOrderedCategories();

    function categoryNumber( $tcat ){ global $orderedCategories; for( $n = 0; $n < count($orderedCategories); $n++ ){ if( $orderedCategories[$n] == $tcat ){ break; } } return $n; }

    function mergeLinkTypes( $customLinkTypes, $resourceLocation )
    {
        global $linkTypes;

        if( is_array($customLinkTypes) )
        {
            foreach( $customLinkTypes as $ccat => $customLinkCat )
            {
                if( !empty($linkTypes[$ccat]) )
                {
                    $existingLinkCat = $linkTypes[$ccat];

                    foreach( $customLinkCat['links'] as $itype => $customLinkType )
                    {
                        if( !empty($existingLinkCat['links'][$itype]) )
                        {
                            $existingLinkType = $existingLinkCat['links'][$itype];
                            foreach( $customLinkType as $setting => $val )
                            {
                                updateLinkType( $itype, $setting, $val );
                            }
                        }
                        else
                        {
                            $linkTypes[$ccat]['links'][$itype] = $customLinkType;
                            if( !empty($resourceLocation) ){ updateLinkType( $itype, "resourceLocation", $resourceLocation ); }
                        }
                    }
                }
                else
                {
                    $linkTypes[$ccat] = $customLinkCat;

                    if( !empty($resourceLocation) )
                    {
                        foreach( $customLinkCat['links'] as $itype => $val )
                        {
                            updateLinkType( $itype, "resourceLocation", $resourceLocation );
                        }
                    }
                }
            }

            doOrderedCategories();
        }
    }

    function linkTypeCondition( $cond, $extra = "" )
    {
        global $linkTypes;

        foreach( $linkTypes as $cat => $category )
        {
            foreach( $category['links'] as $linkType => $link )
            {
                $result = call_user_func_array( $cond, array($cat, $linkType, $link, $extra) );
                if( !empty($result) ){ return $result; }
            }
        }

        return null;
    }

    function typeCompare( $cat, $type, $link, $ltype ){ if( $ltype == $type ){ return $link; } }

    function getLinkType( $ltype )
    {
        return linkTypeCondition( "typeCompare", $ltype );
    }

    function updateLinkType( $ltype, $key, $value )
    {
        global $linkTypes;

        $linkType = getLinkType( $ltype );

        $gotIt = false;

        foreach( $linkTypes as $cat => $category )
        {
            foreach( $category['links'] as $lt => $link )
            {
                if( $lt == $ltype )
                {
                    $linkTypes[$cat]['links'][$lt][$key] = $value;
                    $gotIt = true;
                    break;
                }
            }

            if( $gotIt ){ break; }
        }
    }

    function linkDetect( $cat, $type, $link, $theURL )
    {
        if( !empty($link['detectors']) )
        {
            foreach( $link['detectors'] as $detector )
            {
                if( preg_match( '#' . $detector . '#i', $theURL ) ){ return $type; }
            }
        }
    }

    function detectLinkType( $URL )
    {
        $result = linkTypeCondition( "linkDetect", $URL );

        if( empty($result) ){ $result = 'href'; }

        return $result;
    }

    $roundingRatio = 0.17742;

    function linkImageSize( $fSize )
    {
        $imgSize = 256;

        $adjustedFSize = $fSize * 2;

             if( $adjustedFSize <=  16 ){ $imgSize =  16; }
        else if( $adjustedFSize <=  32 ){ $imgSize =  32; }
        else if( $adjustedFSize <=  64 ){ $imgSize =  64; }
        else if( $adjustedFSize <= 128 ){ $imgSize = 128; }

        return $imgSize;
    }

    function shadowBox( $shadowColor, $size )
    {
        global $roundingRatio;

        switch( $shadowColor )
        {
            case 'blue':  { return "0 0px " + ($size * $roundingRatio) + "px rgb(  0,  0, 192)"; } break;
            case 'black': { return "0 0px " + ($size * $roundingRatio) + "px rgb( 30, 30,  30)"; } break;
                 default: { return "0 2px 2px rgba( 0, 0, 0, 0.3 )";                           }
        }
    }

    function linkTypeImageDiv( $base, $type, $size, $shadowColor = "normal", $rounded = true )
    {
        global $masterPath;
        global $roundingRatio;

        $lt = getLinkType( $type ); if( !$lt ){ $lt = getLinkType("unknown"); }

        $imageSize = linkImageSize( $size );

        $linkTypeImageDiv = "<div data-type='" . $type . "' data-size='" . $size . "' style='position: relative; width: " . $size . "px; max-height: " . $size . "px; vertical-align: middle; height: 100%;' >";

        $theIconImageURL = $base;
        if( (($type != 'image') || (($type == 'image') && ($base == $masterPath))) )
        {
            if( !empty($lt["resourceLocation"]) ){ $theIconImageURL = $lt["resourceLocation"]; }
            $theIconImageURL .= 'linkTypes/' . preg_replace("[0-9]", "", $type) . '/icon/';
            if( !empty($lt["icon"]) ){ $theIconImageURL .= $lt["icon"]; }else{ $theIconImageURL .= $imageSize . '.png'; }
        }

        $iconImageCSS = "";

        if( ((empty($lt["iconBackground"])) || ($lt["iconBackground"] != 'false')) && (($type != 'image') || (($type == 'image') && ($base == $masterPath))) )
        {
            $borderRadius = ""; if( $rounded != false ){ $borderRadius = "border-radius: " . ($size * .17742) . "px;"; }
            $boxShadow = "box-shadow: " . shadowBox( $shadowColor, $size );
            $theIconBackground = "<img src='" . htmlspecialchars($base . 'ultralinkImages/iconBackground' . $imageSize . '.png', ENT_QUOTES) . "' style='width: " . $size . "px; heigth: " . $size . "px; " . $borderRadius . " " . $boxShadow . "' />";

            $linkTypeImageDiv .= $theIconBackground;

            $iconShrinkage = 0.75; if( !empty($lt["iconShrinkage"]) ){ $iconShrinkage = floatval( $lt["iconShrinkage"] ); }
            $iconAdjustX   = 0.0;  if( !empty($lt["iconAdjustX"])   ){ $iconAdjustX   = floatval( $lt["iconAdjustX"]   ); }
            $iconAdjustY   = 0.0;  if( !empty($lt["iconAdjustY"])   ){ $iconAdjustY   = floatval( $lt["iconAdjustY"]   ); }

            $shrinkBugAdjust = 17 - $size; if( $shrinkBugAdjust < 0 ){ $shrinkBugAdjust = 0; }

            $iconImageCSS = "top: " . ($iconAdjustY * $size) . "px; left: " . ($iconAdjustX * $size) . "px; position: absolute; transform: scale( " . $iconShrinkage . ", " . $iconShrinkage . " );";
        }
        else
        {
            if( $type == 'image' ){ $iconImageCSS = "max-width: " . $size . "px; max-height: " . $size . "px;"; }

            if( $rounded != false ){ $iconImageCSS .= " border-radius: " . ($size * $roundingRatio) . "px;"; }

            $iconImageCSS .= " box-shadow: " . shadowBox( $shadowColor, $size ) . ";";
        }

        $theIconImage = "<img src='" . htmlspecialchars($theIconImageURL, ENT_QUOTES) . "' style='width: " . $size . "px; height: " . $size . "px; " . $iconImageCSS . "' />";

        $linkTypeImageDiv .= $theIconImage;

        return $linkTypeImageDiv . "</div>";
    }

?>