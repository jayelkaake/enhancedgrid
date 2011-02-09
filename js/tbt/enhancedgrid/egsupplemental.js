/**
 * Trade Business Technology Corp.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2008-2009 Trade Business Technology Corp. (contact@tbtcorp.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
 
//form tags to omit in NS6+:

var omitformtags=["input", "textarea", "select"]

omitformtags=omitformtags.join("|")

function disableselect(e){
    if (omitformtags.indexOf(e.target.tagName.toLowerCase())==-1)
        return false
}

function reEnable(){
    return true
}

var originalHighlighting = false;

function disableHighlighting() {
    if (typeof document.onselectstart!="undefined") {
        originalHighlighting = document.onselectstart;
        document.onselectstart=new Function ("return false")
    } else{
        originalHighlighting = {
            down: document.onmousedown,
            up:   document.onmouseup
        }
        document.onmousedown=disableselect
        document.onmouseup=reEnable
    }
}

function enableHighlighting() {
    if (typeof document.onselectstart!="undefined") {
        document.onselectstart = originalHighlighting;
    } else{
        document.onmousedown=originalHighlighting.down;
        document.onmouseup=originalHighlighting.up;
    }
}

function keyWasPressed(e, targetKeyNum) {
    var keychar;
    var numcheck;
    
    if(window.event) // IE
    {
        keynum = e.keyCode;
    }
    else if(e.which) // Netscape/Firefox/Opera
    {
        keynum = e.which;
    }
    if(keynum == targetKeyNum) return true;
    return false;
}