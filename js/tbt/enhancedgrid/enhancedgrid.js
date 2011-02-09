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


varienGrid.prototype.initialize = function(containerId, url, pageVar, sortVar, dirVar, filterVar){
    this.containerId = containerId;
    this.url = url;
    this.pageVar = pageVar || false;
    this.sortVar = sortVar || false;
    this.dirVar  = dirVar || false;
    this.filterVar  = filterVar || false;
    this.tableSufix = '_table';
    this.useAjax = false;
    this.rowClickCallback = false;
    this.checkboxCheckCallback = false;
    this.preInitCallback = false;
    this.initCallback = false;
    this.initRowCallback = false;
    this.doFilterCallback = false;
    
    // muliselect row
    this.selectedRowEvents = {};
    this.doMultiSelect = false;
    this.multiSelectFunction = function(events) {
        this.onMultiSelect(events);
    };
    

    this.reloadParams = false;

    this.trOnMouseOver  = this.rowMouseOver.bindAsEventListener(this);
    this.trOnMouseOut   = this.rowMouseOut.bindAsEventListener(this);
    this.trOnMouseUp   = this.rowMouseUp.bindAsEventListener(this);
    this.trOnMouseDown   = this.rowMouseDown.bindAsEventListener(this);
    this.trOnMouseMove  = this.rowMouseMove.bindAsEventListener(this);
    this.trOnClick      = this.rowMouseClick.bindAsEventListener(this);
    this.trOnDblClick   = this.rowMouseDblClick.bindAsEventListener(this);
    this.trOnKeyPress   = this.keyPress.bindAsEventListener(this);

    this.thLinkOnClick      = this.doSort.bindAsEventListener(this);
    this.initGrid();
};


varienGrid.prototype.initGrid = function(){
    if(this.preInitCallback){
        this.preInitCallback(this);
    }
    if($(this.containerId+this.tableSufix)){
        this.rows = $$('#'+this.containerId+this.tableSufix+' tbody tr');
        for (var row=0; row<this.rows.length; row++) {
            if(row%2==0){
                Element.addClassName(this.rows[row], 'even');
            }
            Event.observe(this.rows[row],'mouseover',this.trOnMouseOver);
            Event.observe(this.rows[row],'mouseout',this.trOnMouseOut);
            Event.observe(this.rows[row],'click',this.trOnClick);
            Event.observe(this.rows[row],'dblclick',this.trOnDblClick);
            Event.observe(this.rows[row],'mouseup',this.trOnMouseUp);
            Event.observe(this.rows[row],'mousedown',this.trOnMouseDown);
            Event.observe(this.rows[row],'mousemove',this.trOnMouseMove);

            if(this.initRowCallback){
                try {
                    this.initRowCallback(this, this.rows[row]);
                } catch (e) {
                    if(console) {
                        console.log(e);
                    }
                }
            }
        }
    }
    if(this.sortVar && this.dirVar){
        var columns = $$('#'+this.containerId+this.tableSufix+' thead a');

        for(var col=0; col<columns.length; col++){
            Event.observe(columns[col],'click',this.thLinkOnClick);
        }
    }
    this.bindFilterFields();
    this.bindFieldsChange();
    if(this.initCallback){
        try {
            this.initCallback(this);
        }
        catch (e) {
            if(console) {
                console.log(e);
            }
        }
    }
};
varienGrid.prototype.rowMouseOver = function(event){
    var element = Event.findElement(event, 'tr');
    Element.addClassName(element, 'on-mouse');

    if (!Element.hasClassName('pointer')
        && (this.rowClickCallback !== openGridRow || element.id)) {
        Element.addClassName(element, 'pointer');
    }
    if(this.doMultiSelect) {
        if (this.addMultiSelectedRow(event, element)) {
        // row is already selected...
        } else {
            Element.addClassName(element, 'multiselect')
        }
    }
};
varienGrid.prototype.rowMouseMove = function(event){
    };
varienGrid.prototype.addMultiSelectedRow = function(event, rowElement) {
    var checkbox = this.findCheckbox(event);
    var newId = checkbox.value;
    if(this.selectedRowEvents[newId] != null) {
        return false;
    }
    this.selectedRowEvents[newId] = {
        event: event,
        rowElement: rowElement,
        checkbox: checkbox
    };
};
varienGrid.prototype.findCheckbox = function(evt) {
    if(['a', 'input', 'select'].indexOf(Event.element(evt).tagName.toLowerCase())!==-1) {
        return false;
    }
    checkbox = false;
    Event.findElement(evt, 'tr').getElementsBySelector('input[type=checkbox]').each(function(element){
        checkbox = element;
    }.bind(this));
    return checkbox;
};
varienGrid.prototype.removeMultiSelectedRow = function(event, rowElement) {
    if(this.selectedRowEvents[rowElement.id] != null) {
        this.selectedRowEvents[rowElement.id] = null;
    }
    return false;
}
varienGrid.prototype.rowMouseUp = function(event){
    if(this.doMultiSelect) {
        enableHighlighting();
        this.doMultiSelect = false;
        this.multiSelectFunction(this.selectedRowEvents);
    }
};
varienGrid.prototype.rowMouseDown = function(event){
    if(event.ctrlKey) {
        if(['a', 'input', 'select'].indexOf(Event.element(event).tagName.toLowerCase())!==-1) {
            return false;
        }
        disableHighlighting();
        this.doMultiSelect = true;
        this.selectedRowEvents = {};
        // Add the row we just clicked on
        var element = Event.findElement(event, 'tr');
        this.addMultiSelectedRow(event, element);
        Element.addClassName(element, 'multiselect')
    }
}
varienGrid.prototype.rowMouseClick = function(event){
    if(this.doMultiSelect) {
        this.doMultiSelect = false;
        return;
    }
    if(event.ctrlKey) return;
        
    if(this.rowClickCallback){
        try{
            this.rowClickCallback(this, event);
        }
        catch(e){}
    }
    varienGlobalEvents.fireEvent('gridRowClick', event);
};
// Multiselect 
varienGrid.prototype.onMultiSelect = function(events) {
    for(rowid in events) {
        var multiRowEvent = events[rowid];
        var checkbox = multiRowEvent.checkbox;
        this.setCheckboxChecked(checkbox, checkbox.checked ? false : true);
        multiRowEvent.rowElement.blur();
        Element.removeClassName(multiRowEvent.rowElement, 'multiselect');
    }
}


varienGridMassaction.prototype.initialize = function (containerId, grid, checkedValues, formFieldNameInternal, formFieldName) {
    // MAGE -- begin
    this.setOldCallback('row_click', grid.rowClickCallback);
    this.setOldCallback('init',      grid.initCallback);
    this.setOldCallback('init_row',  grid.initRowCallback);
    this.setOldCallback('pre_init',  grid.preInitCallback);

    this.useAjax        = false;
    this.grid           = grid;
    this.containerId    = containerId;
    this.initMassactionElements();

    this.checkedString          = checkedValues;
    this.formFieldName          = formFieldName;
    this.formFieldNameInternal  = formFieldNameInternal;

    this.grid.initCallback      = this.onGridInit.bind(this);
    this.grid.preInitCallback   = this.onGridPreInit.bind(this);
    this.grid.initRowCallback   = this.onGridRowInit.bind(this);
    this.grid.rowClickCallback  = this.onGridRowClick.bind(this);
    this.initCheckboxes();
    this.checkCheckboxes();
    // MAGE -- end
        
    // Magento ver < 1.16
    if (typeof(varienStringArray) == 'undefined') {
        this.mageIsLessThan116 = true;
    }
        
    // TBT -- enhanced grid -- begin
    this.grid.multiSelectFunction = this.onMultiSelect.bind(this);
    //this.selectedRows = false;

    if(checkedValues != "") {
        checkedValues.each(function(item){
            this.checkedValues[item] = item;
        }.bind(this));
    }
};
// Multiselect 
varienGridMassaction.prototype.onMultiSelect = function(events) {
    this.grid.onMultiSelect(events);
    var checkValues = new Array();
    var uncheckValues = new Array();
    for(rowid in events) {
        var checkVal = events[rowid].checkbox.value;
        if(events[rowid].checkbox.checked) {
            checkValues.push(checkVal);
            if(!this.mageIsLessThan116)
                this.checkedString = varienStringArray.add(checkVal, this.checkedString);
        } else {
            uncheckValues.push(checkVal);
            if(!this.mageIsLessThan116)
                this.checkedString = varienStringArray.remove(checkVal, this.checkedString);
        }
    }

    if(this.mageIsLessThan116) {
        this.addCheckedValues(checkValues);
        this.unsetCheckedValues(uncheckValues);
    }
    this.updateCount();
};
varienGridMassaction.prototype.apply = function() {
    var item = this.getSelectedItem();
    if(!item) {
        this.validator.validate();
        return;
    }
    this.currentItem = item;
        
    var fieldName = "";
    if (item.field == undefined) {
        fieldName = this.formFieldName
    }
    fieldName += '[]';
        
    var fieldsHtml = '';
    var callbackVal = null;
    var multiFields = item.fields;
        
    if(this.currentItem.callback) {
        callbackVal = eval(this.currentItem.callback.replace("{checkedValues}", "'"+ this.getCheckedValues()+"'"));
        if (callbackVal == null) {
            return;
        }
          
        var formCallbackVal = document.createElement('input');
        formCallbackVal.type = "hidden";
        formCallbackVal.value = callbackVal;
        formCallbackVal.name = "callbackval";
        this.form.appendChild(formCallbackVal);
    }
        
    if(this.currentItem.confirm && !window.confirm(this.currentItem.confirm)) {
        return;
    }

    /* Maybe in future
        this.getOnlyExistsCheckedValues().each(function(item){
            fieldsHtml += this.fieldTemplate.evaluate({name: fieldName, value: item});
        }.bind(this)); */

    // ENHANCED GRID BEGIN (MAGE END)
    var itArray;
    if (this.mageIsLessThan116) {
        itArray = this.getCheckedValues();
    } else {
        itArray = this.getCheckedValues().split(",");
    }
        
    itArray.each(function(item){
        if(multiFields != null) {
            for (var i=0; i<multiFields.length; i++) {
                fieldsHtml += this.fieldTemplate.evaluate({
                    name: multiFields[i]+'[]', 
                    value: item
                });
            }
        } else {
            fieldsHtml += this.fieldTemplate.evaluate({
                name: fieldName, 
                value: item
            });
        }
    }.bind(this));
    this.formHiddens.update(fieldsHtml);

    // ENHANCED GRID END (MAGE BEGIN)
    if(!this.validator.validate()) {
        return;
    }


    if(this.useAjax && item.url) {
        new Ajax.Request(item.url, {
            'method': 'post',
            'parameters': this.form.serialize(true),
            'onComplete': this.onMassactionComplete.bind(this)
        });
    } else if(item.url) {
        this.form.action = item.url;
        this.form.submit();
    }
};
varienGridMassaction.prototype.walkSelectedRows = function(walkFunction, warningLimit) {
    if(warningLimit == undefined) warningLimit = 100;
    var selectedRowCount = 0;
    var abort = false;
    this.grid.rows.each(function(ie) {
        var rcheckboxs = ie.getElementsBySelector('input[type=checkbox]').each(function(chk) {
            if(chk.checked) {
                if(abort) return;
                walkFunction(ie); //user function
            
                // checks for abort.
                selectedRowCount++;
                if(selectedRowCount == warningLimit) {
                    if(!window.confirm("There are over 100 rows processing, should the script continue?")) {
                        abort = true;
                    }
                }
            }
        });
    });
}
varienGrid.prototype.doFilter = function(){
    var filters = $$('#'+this.containerId+' .filter input', '#'+this.containerId+' .filter select');
    var searchQry = $$('#'+this.containerId+' .filter input', '#'+this.containerId+' .filter select');
    var elements = [];
    for(var i in filters){
        if(filters[i].value && filters[i].value.length) elements.push(filters[i]);
    }
    if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
        if($$('input#enhancedGridSearchQry')[0] != undefined) {
            this.addVarToUrl('q', $$('input#enhancedGridSearchQry')[0].value);
        }
        this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
    }
}
varienGrid.prototype.resetFilter = function(){
    if($$('input#enhancedGridSearchQry')[0] != undefined) {
        this.addVarToUrl('q', '')
    }
    this.addVarToUrl(this.filterVar, '')
    this.reload();
}
