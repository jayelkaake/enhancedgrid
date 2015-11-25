/**
 * Sweet Tooth.
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
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Sweet Tooth
 *
 * @copyright  Copyright (c) 2008-2011 Sweet Tooth (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
function chooseWhatToRelateTo() {
    var productids = window.prompt("Enter the id's for products you'd like to relate the currently selected products to.\n" + "For example: Suppose you selected X, Y and Z.  If you enter 'A,B' here, X will be\n" + "related to A and B, Y will be related to A and B, etc.\n" + "Separate multiple product ids by a comma as shown in the example above.", "<Enter product IDs (NOT SKUs!)>");
    if (productids == "" || productids == null) {
        return null
    }
    if (!window.confirm("Are you sure you'd like to one-way relate selected grid products to products (" + productids + ")")) {
        return null
    }
    return productids;
}

function chooseWhatToCrossSellTo() {
    var productids = window.prompt("Enter the id's for products you'd like to add as cross-sell to the currently selected products.\n" + "For example: Suppose you selected X, Y and Z.  If you enter 'A,B' here, X will be\n" + "cross-sold to A and B, Y will be cross-sold with A and with B, etc.\n" + "Separate multiple product ids by a comma as shown in the example above.", "<Enter product IDs (NOT SKUs!)>");
    if (productids == "" || productids == null) {
        return null
    }
    if (!window.confirm("Are you sure you'd like to one-way cross-sell products (" + productids + ") to selected grid products?")) {
        return null
    }
    return productids;
}

function chooseWhatToUpSellTo() {
    var productids = window.prompt("Enter the id's for products you'd like to add as up-sells to the currently selected products.\n" + "For example: Suppose you selected X, Y and Z.  If you enter 'A,B' here, A and B will be\n" + "up-sells of X , A and B will be up-sells of Y, etc.\n" + "Separate multiple product ids by a comma as shown in the example above.", "<Enter product IDs (NOT SKUs!)>");
    if (productids == "" || productids == null) {
        return null
    }
    if (!window.confirm("Are you sure you'd like add products (" + productids + ") to selected grid products up-sell?")) {
        return null
    }
    return productids;
}



function showSelectedImages(gridObj, checkedValues, imgTemplate) {
    var matchCounter = 0;
    gridObj.walkSelectedRows(function(ie) {
        ie.getElementsBySelector('a').each(function(a) {
            if (a.id == "imageurl") {
                matchCounter++;
                a.innerHTML = imgTemplate.replace("{imgurl}", a.getAttribute('url'));
            }
        });
    });
    if (matchCounter == 0) {
        alert("Either there was no image column, or the image column could not be found");
    }
    return null;

}

function hideSelectedImages(gridObj, checkedValues) {
    var matchCounter = 0;
    gridObj.walkSelectedRows(function(ie) {
        ie.getElementsBySelector('a').each(function(a) {
            if (a.id == "imageurl") {
                matchCounter++;
                a.innerHTML = "@";
            }
        });
    });
    if (matchCounter == 0) {
        alert("Either there was no image column, or the image column could not be found");
    }
    return null;

}

function openAllImages(gridObj, checkedValues) {
    gridObj.walkSelectedRows(function(ie) {
        ie.getElementsBySelector('a').each(function(a) {
            if (a.id == "imageurl") {
                window.open(a.getAttribute('url'));
            }
        });
    }, 30);
    return null;

}

function openAll(gridObj, checkedValues) {
    gridObj.walkSelectedRows(function(ie) {
        window.open(ie.id);
    }, 20);
    return null;

}