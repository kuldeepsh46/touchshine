/**
 * Shuttle box
 */
var Transfer = (function ($) {
    // Global variables, the number of selected items
    var selected_total_num = 0;
    // Current time, used as id
    var currentTimeStr = (new Date()).getTime() + parseInt(10000 * Math.random());
    // input of id
    var inputId = "";

    /**
     * Construct a shuttle box
     * @param settings Setting item
     */
    function transfer(settings) {

        inputId = settings.inputId;
        // The name of the data item
        var itemName = settings.itemName;
        // Group name
        var groupItemName = settings.groupItemName;
        // Grouped list name
        var groupListName = settings.groupListName;
        // The name of the value
        var valueName = settings.valueName;
        // container
        var container = "." + settings.container;
        // Callback function for data changes
        var callable = settings.callable;
        // Shuttle box
        var transferId = "#transfer_double_" + inputId;

        // Receive selected item text box
        var selectInputId = "#" + inputId;

        // List data
        var data = settings.data || [];
        // Group list data
        var groupData = settings.groupData || [];

        // Total number of data items
        var total_num = settings.data.length;
        // Total number display text
        var total_num_str = settings.data.length + " Items";

        // Total number of groups
        var total_group_num = getGroupNum(groupData, groupListName);
        // Display text of the total number of groups
        var total_group_num_str = total_group_num + " Items";

        // New total number
        var new_total_num = 0;
        // Total number of new groups
        var new_group_total_num = 0;

        // Bookmark page
        var tabItemName = ".tab-item-name-" + currentTimeStr;
        // Tab content
        var transferDoubleList = ".transfer-double-list-" + currentTimeStr;

        // Search box on the left id
        var listSearchId = "#listSearch_" + currentTimeStr;
        // Group search box on the left id
        var groupListSearchId = "#groupListSearch_" + currentTimeStr;
        // Search box on the right id
        var selectedListSearchId = "#selectedListSearch_" + currentTimeStr;

        // Items not selected on the left
        var tabContentFirst = ".tab-content-first-" + currentTimeStr;
        // List of unselected items on the left ul
        var transferDoubleListUl = ".transfer-double-list-ul-" + currentTimeStr;
        // List of unselected items on the left li
        var transferDoubleListLi = ".transfer-double-list-li-" + currentTimeStr;
        // Left list item checkbox
        var checkboxItem = ".checkbox-item-" + currentTimeStr;
        // List item name on the left
        var checkboxName = ".checkbox-name-" + currentTimeStr;
        // The total number of display elements on the left
        var totalNum = ".total_num_" + currentTimeStr;
        // Select all unchecked items on the left id
        var selectAllId = "#selectAll_" + currentTimeStr;

        // Group list on the left ul
        var transferDoubleGroupListUl = ".transfer-double-group-list-ul-" + currentTimeStr;
        // Group list on the left li
        var transferDoubleGroupListLi = ".transfer-double-group-list-li-" + currentTimeStr;
        //The grouping list on the left is grouping select all, it is grouping select all, not all
        var groupSelectAll = ".group-select-all-" + currentTimeStr;
        // Group name in the left group list
        var groupName = ".group-name-" + currentTimeStr;
        // Different groups on the left ul
        var transferDoubleGroupListLiUl = ".transfer-double-group-list-li-ul-" + currentTimeStr;
        // Different groups on the left li
        var transferDoubleGroupListLiUlLi = ".transfer-double-group-list-li-ul-li-" + currentTimeStr;
        // Different groups on the left checkbox
        var groupCheckboxItem = ".group-checkbox-item-" + currentTimeStr;
        // Names of different grouping options on the left
        var groupCheckboxName = ".group-checkbox-name-" + currentTimeStr;
        // Display the total number of elements grouped on the left
        var groupTotalNum = ".group_total_num_" + currentTimeStr;
        // The group list is not selected on the left, select all id
        var groupsSelectAllId = "#groupsSelectAll_" + currentTimeStr;

        // List on the right ul
        var transferDoubleSelectedListUl = ".transfer-double-selected-list-ul-" + currentTimeStr;
        // List on the right li
        var transferDoubleSelectedListLi = ".transfer-double-selected-list-li-" + currentTimeStr;
        // Selected item in the right list
        var checkboxSelectedItem = ".checkbox-selected-item-" + currentTimeStr;
        // Name of the selected item in the right list
        var checkboxSelectedName = ".checkbox-selected-name-" + currentTimeStr;
        // Select all on the right id，Reserved for future use
        var selectedAllId = "#selectedAll_" + currentTimeStr;
        // The total number of display elements on the right
        var selectedTotalNum = ".selected_total_num_" + currentTimeStr;

        // Add button to the right
        var addSelected = "#add_selected_" + currentTimeStr;
        // Add button to the left
        var deleteSelected = "#delete_selected_" + currentTimeStr;


        // Shuttle frame rendering
        $(container).append(generateTransfer(inputId, currentTimeStr));

        /**
         * Data rendering
         */
        $(transferId).find(transferDoubleListUl).empty();
        $(transferId).find(transferDoubleListUl).append(generateLeftList(currentTimeStr, data, itemName, valueName));
        $(transferId).find(totalNum).empty();
        $(transferId).find(totalNum).append(total_num_str);

        $(transferId).find(transferDoubleGroupListUl).empty();
        $(transferId).find(transferDoubleGroupListUl).append(generateLeftGroupList(currentTimeStr, groupData, itemName, groupListName, groupItemName, valueName));
        $(transferId).find(groupTotalNum).empty();
        $(transferId).find(groupTotalNum).append(total_group_num_str);

        /**
         * Click tab switch
         */
        $(transferId).find(tabItemName).on("click", function () {
            $(selectAllId).prop("checked", false);
            if (!$(this).is(".tab-active")) {
                $(this).addClass("tab-active").siblings().removeClass("tab-active");
                $(transferDoubleList).eq($(transferId).find(tabItemName).index(this)).addClass("tab-content-active").siblings().removeClass("tab-content-active");
                $(transferId).find(".checkbox-normal").each(function () {
                    $(this).prop("checked", false);
                });
                $(addSelected).removeClass("btn-arrow-active");
                $(transferId).find(transferDoubleSelectedListUl).empty();
                // Clear the right quantity
                $(transferId).find(selectedTotalNum).text("0 Items");
                // Unchecked item
                if ($(transferId).find(tabContentFirst).css("display") != "none") {
                    $(transferId).find(transferDoubleGroupListLiUlLi).each(function () {
                        $(this).css('display', 'block');
                    });
                    $(transferId).find(groupCheckboxItem).each(function () {
                        $(this).prop("checked", false);
                    });

                    $(transferId).find(selectAllId).prop("disabled", "");

                    $(transferId).find(groupTotalNum).empty();
                    $(transferId).find(groupTotalNum).append($(transferId).find(transferDoubleGroupListLiUlLi).length + " Items");
                } else {
                    // Grouping

                    // Empty disabled
                    for (var j = 0; j < $(transferId).find(groupSelectAll).length; j++) {
                        $(transferId).find(groupSelectAll).eq(j).prop("disabled", "");
                    }
                    $(transferId).find(groupsSelectAllId).prop("disabled", "");

                    $(transferId).find(transferDoubleListLi).each(function () {
                        $(this).css('display', 'block');
                    });
                    $(transferId).find(checkboxItem).each(function () {
                        $(this).prop("checked", false);
                    });
                    $(transferId).find(totalNum).empty();
                    $(transferId).find(totalNum).append($(transferId).find(transferDoubleListLi).length + " Items");
                }
                // Data change triggers callback
                callable.call(this, getSelected(), getSelectedName());
                // Change the label switch button to inactive
                $(addSelected).removeClass("btn-arrow-active");
                $(deleteSelected).removeClass("btn-arrow-active");
            }
        });

        /**
         * Monitor whether the unselected item checkBox on the left is selected
         */
        $(transferId).on("click", checkboxItem, function () {
            var selected_num = 0;
            for (var i = 0; i < $(transferId).find(checkboxItem).length; i++) {
                if ($(transferId).find(transferDoubleListLi).eq(i).css('display') != "none" && $(transferId).find(checkboxItem).eq(i).is(':checked')) {
                    selected_num++;
                }
            }
            if (selected_num > 0) {
                $(addSelected).addClass("btn-arrow-active");
            } else {
                $(addSelected).removeClass("btn-arrow-active");
            }
        });

        /**
         * Monitor whether the group checkBox on the left is selected
         */
        $(transferId).on("click", groupCheckboxItem, function () {
            var selected_num = 0;
            for (var i = 0; i < $(transferId).find(groupCheckboxItem).length; i++) {
                if ($(transferId).find(transferDoubleGroupListLiUlLi).eq(i).css('display') != "none" && $(transferId).find(groupCheckboxItem).eq(i).is(':checked')) {
                    selected_num++;
                }
            }
            if (selected_num > 0) {
                $(addSelected).addClass("btn-arrow-active");
            } else {
                $(addSelected).removeClass("btn-arrow-active");
            }
        });

        // Monitor whether the unselected item checkBox on the right is selected
        $(transferId).on("click", checkboxSelectedItem, function () {
            var deleted_num = 0;
            for (var i = 0; i < $(transferId).find(checkboxSelectedItem).length; i++) {
                if ($(transferId).find(checkboxSelectedItem).eq(i).is(':checked')) {
                    deleted_num++;
                }
            }
            if (deleted_num > 0) {
                $(deleteSelected).addClass("btn-arrow-active");
            } else {
                $(deleteSelected).removeClass("btn-arrow-active");
            }
        });

        // Select or deselect all unselected items in the group
        $(groupSelectAll).on("click", function () {
            // Group index
            var groupIndex = ($(this).attr("id")).split("_")[1];
            // A group is selected
            if ($(this).is(':checked')) {
                // Activate button
                $(addSelected).addClass("btn-arrow-active");
                for (var i = 0; i < $(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).length; i++) {
                    if (!$(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).eq(i).is(':checked') && $(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).eq(i).parent().parent().css("display") != "none") {
                        // If attr is used here, there will be a third failure
                        $(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).eq(i).prop("checked", true);
                    }
                }
                var groupCheckedNum = 0;
                $(transferId).find(groupSelectAll).each(function () {
                    if ($(this).is(":checked")) {
                        groupCheckedNum = groupCheckedNum + 1;
                    }
                });
                if (groupCheckedNum == $(transferId).find(groupSelectAll).length) {
                    $(groupsSelectAllId).prop("checked", true);
                }
            } else {
                for (var j = 0; j < $(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).length; j++) {
                    if ($(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).eq(j).is(':checked') && $(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).eq(i).parent().parent().css("display") != "none") {
                        $(transferId).find(".belongs-group-" + groupIndex + "-" + currentTimeStr).eq(j).prop("checked", false);
                    }
                }
                var groupCheckedNum = 0;
                $(transferId).find(groupSelectAll).each(function () {
                    if ($(this).is(":checked")) {
                        groupCheckedNum = groupCheckedNum + 1;
                    }
                });
                if (groupCheckedNum != $(transferId).find(groupSelectAll).length) {
                    $(groupsSelectAllId).prop("checked", false);
                }
                if (groupCheckedNum == 0) {
                    $(addSelected).removeClass("btn-arrow-active");
                }
            }
        });

        /**
         *List select all
         */
        $(selectAllId).on("click", function () {
            if ($(this).is(':checked')) {
                for (var i = 0; i < $(transferId).find(checkboxItem).length; i++) {
                    if ($(transferId).find(transferDoubleListLi).eq(i).css('display') != "none" && !$(transferId).find(checkboxItem).eq(i).is(':checked')) {
                        //If attr is used here, there will be a third failure
                        $(transferId).find(checkboxItem).eq(i).prop("checked", true);
                    }
                }
                $(addSelected).addClass("btn-arrow-active");
            } else {
                for (var i = 0; i < $(transferId).find(checkboxItem).length; i++) {
                    if ($(transferId).find(transferDoubleListLi).eq(i).css('display') != "none" && $(transferId).find(checkboxItem).eq(i).is(':checked')) {
                        $(transferId).find(checkboxItem).eq(i).prop("checked", false);
                    }
                }
                $(addSelected).removeClass("btn-arrow-active");
            }
        });

        /**
         * Group select all
         */
        $(groupsSelectAllId).on("click", function () {
            if ($(this).is(':checked')) {
                for (var i = 0; i < $(transferId).find(groupCheckboxItem).length; i++) {
                    if ($(transferId).find(transferDoubleGroupListLiUlLi).eq(i).css('display') != "none" && !$(transferId).find(groupCheckboxItem).eq(i).is(':checked')) {
                        // If attr is used here, there will be a third failure
                        $(transferId).find(groupCheckboxItem).eq(i).prop("checked", true);
                    }
                    if (!$(transferId).find(groupSelectAll).eq(i).is(':checked')) {
                        $(transferId).find(groupSelectAll).eq(i).prop("checked", true);
                    }
                }
                $(addSelected).addClass("btn-arrow-active");
            } else {
                for (var i = 0; i < $(transferId).find(groupCheckboxItem).length; i++) {
                    if ($(transferId).find(transferDoubleGroupListLiUlLi).eq(i).css('display') != "none" && $(transferId).find(groupCheckboxItem).eq(i).is(':checked')) {
                        $(transferId).find(groupCheckboxItem).eq(i).prop("checked", false);
                    }
                    if ($(transferId).find(groupSelectAll).eq(i).is(':checked')) {
                        $(transferId).find(groupSelectAll).eq(i).prop("checked", false);
                    }
                }
                $(addSelected).removeClass("btn-arrow-active");
            }
        });

        /**
         * Add selected items to the right
         */
        $(addSelected).on("click", function () {
            var listHtmlStr = "";
            var selectedItemNum = 0;
            // Grouping
            if ($(transferId).find(tabContentFirst).css("display") != "none") {
                for (var i = 0; i < $(transferId).find(groupCheckboxItem).length; i++) {
                    if ($(transferId).find(groupCheckboxItem).eq(i).is(':checked')) {
                        var checkboxItemId = $(transferId).find(groupCheckboxItem).eq(i).attr("id");
                        var checkboxItemArray = checkboxItemId.split("_");
                        var groupIdIndex = checkboxItemArray[1];
                        var idIndex = checkboxItemArray[3];
                        var val = $(transferId).find(groupCheckboxName).eq(i).text();
                        var value = $(transferId).find(groupCheckboxItem).eq(i).val();
                        $(transferId).find(transferDoubleGroupListLiUlLi).eq(i).css('display', 'none');
                        listHtmlStr = listHtmlStr + '<li class="transfer-double-selected-list-li transfer-double-selected-list-li-' + currentTimeStr + ' .clearfix">' +
                            '<div class="checkbox-group">' +
                            '<input type="checkbox" value="' + value + '" class="checkbox-normal checkbox-selected-item-' + currentTimeStr + '" id="group_' + groupIdIndex + '_selectedCheckbox_' + idIndex + '_' + currentTimeStr + '">' +
                            '<label class="checkbox-selected-name-' + currentTimeStr + '" for="group_' + groupIdIndex + '_selectedCheckbox_' + idIndex + '_' + currentTimeStr + '">' + val + '</label>' +
                            '</div>' +
                            '</li>'
                        selectedItemNum = selectedItemNum + 1;
                    }
                }
                for (var j = 0; j < $(transferId).find(groupSelectAll).length; j++) {
                    if ($(transferId).find(groupSelectAll).eq(j).is(":checked")) {
                        $(transferId).find(groupSelectAll).eq(j).prop("disabled", "disabled");
                    }
                }
                $(transferId).find(groupTotalNum).empty();
                // Calculate the total on the left
                new_group_total_num = total_group_num - selectedItemNum;
                //Calculate the total on the right
                selected_total_num = selectedItemNum;
                var new_total_num_str = new_group_total_num + " Items";
                // Number on the left
                $(transferId).find(groupTotalNum).append(new_total_num_str);
                // Quantity on the right
                $(transferId).find(selectedTotalNum).text(selected_total_num + " Items");
                if (new_group_total_num == 0) {
                    $(groupsSelectAllId).prop("checked", true);
                    $(groupsSelectAllId).prop("disabled", "disabled");
                }
            } else {
                //Unchecked item
                for (var i = 0; i < $(transferId).find(checkboxItem).length; i++) {
                    if ($(transferId).find(checkboxItem).eq(i).is(':checked')) {
                        var checkboxItemId = $(transferId).find(checkboxItem).eq(i).attr("id");
                        var idIndex = checkboxItemId.split("_")[1];
                        var val = $(transferId).find(checkboxName).eq(i).text();
                        var value = $(transferId).find(checkboxItem).eq(i).val();
                        $(transferId).find(transferDoubleListLi).eq(i).css('display', 'none');
                        listHtmlStr = listHtmlStr + '<li class="transfer-double-selected-list-li  transfer-double-selected-list-li-' + currentTimeStr + ' .clearfix">' +
                            '<div class="checkbox-group">' +
                            '<input type="checkbox" value="' + value + '" class="checkbox-normal checkbox-selected-item-' + currentTimeStr + '" id="selectedCheckbox_' + idIndex + '_' + currentTimeStr + '">' +
                            '<label class="checkbox-selected-name-' + currentTimeStr + '" for="selectedCheckbox_' + idIndex + '_' + currentTimeStr + '">' + val + '</label>' +
                            '</div>' +
                            '</li>';
                        selectedItemNum = selectedItemNum + 1;
                    }
                }
                $(transferId).find(totalNum).empty();
                // Calculate the new left total
                new_total_num = total_num - selectedItemNum;
                // Calculate the total on the right
                selected_total_num = selectedItemNum;
                var new_total_num_str = new_total_num + " Items";
                // Number on the left
                $(transferId).find(totalNum).append(new_total_num_str);
                // Quantity on the right
                $(transferId).find(selectedTotalNum).text(selected_total_num + " Items");
                if (new_total_num == 0) {
                    $(selectAllId).prop("checked", true);
                    $(selectAllId).prop("disabled", "disabled");
                }
            }
            $(addSelected).removeClass("btn-arrow-active");
            $(transferId).find(transferDoubleSelectedListUl).empty();
            $(transferId).find(transferDoubleSelectedListUl).append(listHtmlStr);
            //Data change triggers callback
            callable.call(this, getSelected(), getSelectedName());
        });

        /**
         *Delete the selected item and go back to the left
         */
        $(deleteSelected).on("click", function () {
            var deleteItemNum = 0;
            // Grouping
            if ($(transferId).find(tabContentFirst).css("display") != "none") {
                for (var i = 0; i < $(transferId).find(checkboxSelectedItem).length;) {
                    if ($(transferId).find(checkboxSelectedItem).eq(i).is(':checked')) {
                        var checkboxSelectedItemId = $(transferId).find(checkboxSelectedItem).eq(i).attr("id");
                        var groupItemIdArray = checkboxSelectedItemId.split("_")
                        var groupId = groupItemIdArray[1];
                        var idIndex = groupItemIdArray[3];
                        $(transferId).find(transferDoubleSelectedListLi).eq(i).remove();
                        $(transferId).find("#group_" + groupId + "_" + currentTimeStr).prop("checked", false);
                        $(transferId).find("#group_" + groupId + "_" + currentTimeStr).removeAttr("disabled");
                        $(transferId).find("#group_" + groupId + "_checkbox_" + idIndex + "_" + currentTimeStr).prop("checked", false);
                        $(transferId).find("#group_" + groupId + "_checkbox_" + idIndex + "_" + currentTimeStr).parent().parent().css('display', 'block');
                        deleteItemNum = deleteItemNum + 1;
                    } else {
                        i++;
                    }
                }
                $(transferId).find(groupTotalNum).empty();
                // Calculate the total on the left
                new_group_total_num = new_group_total_num + deleteItemNum;
                // Calculate the total on the right
                selected_total_num -= deleteItemNum;
                var new_total_num_str = new_group_total_num + " Items";
                //Total left
                $(transferId).find(groupTotalNum).append(new_total_num_str);
                // Total right
                $(transferId).find(selectedTotalNum).text(selected_total_num + " Items");
                if ($(groupsSelectAllId).is(':checked')) {
                    $(groupsSelectAllId).prop("checked", false);
                    $(groupsSelectAllId).removeAttr("disabled");
                }
            } else {
                // Unchecked item
                for (var i = 0; i < $(transferId).find(checkboxSelectedItem).length;) {
                    if ($(transferId).find(checkboxSelectedItem).eq(i).is(':checked')) {
                        var checkboxSelectedItemId = $(transferId).find(checkboxSelectedItem).eq(i).attr("id");
                        var idIndex = checkboxSelectedItemId.split("_")[1];
                        var val = $(transferId).find(checkboxSelectedName).eq(i).text();
                        $(transferId).find(transferDoubleSelectedListLi).eq(i).remove();
                        $(transferId).find(checkboxItem).eq(idIndex).prop("checked", false);
                        $(transferId).find(transferDoubleListLi).eq(idIndex).css('display', 'block');
                        deleteItemNum = deleteItemNum + 1;
                    } else {
                        i++;
                    }
                }
                $(transferId).find(totalNum).empty();
                // Calculate the total on the left
                new_total_num = new_total_num + deleteItemNum;
                // Calculate the total on the right
                selected_total_num -= deleteItemNum;
                var new_total_num_str = new_total_num + " Items";
                // Total left
                $(transferId).find(totalNum).append(new_total_num_str);
                // Total right
                $(transferId).find(selectedTotalNum).text(selected_total_num + " Items");
                if ($(selectAllId).is(':checked')) {
                    $(selectAllId).prop("checked", false);
                    $(selectAllId).removeAttr("disabled");
                }
            }
            $(deleteSelected).removeClass("btn-arrow-active");
            // Data change triggers callback
            callable.call(this, getSelected(), getSelectedName());
        });

        /**
         * Fuzzy query on the left
         */
        $(listSearchId).on("keyup", function () {
            // Just type in to show list box
            $(transferId).find(transferDoubleListUl).css('display', 'block');
            //If nothing is filled, keep all displayed
            if ($(listSearchId).val() == "") {
                for (var i = 0; i < $(transferId).find(checkboxItem).length; i++) {
                    if (!$(transferId).find(checkboxItem).eq(i).is(':checked')) {
                        $(transferId).find(transferDoubleListLi).eq(i).css('display', 'block');
                    }
                }
                return;
            }

            // If you fill in, hide all options first
            $(transferId).find(transferDoubleListLi).css('display', 'none');

            for (var j = 0; j < $(transferId).find(transferDoubleListLi).length; j++) {
                // Fuzzy matching, display all matching items
                if (!$(transferId).find(checkboxItem).eq(j).is(':checked')
                    && $(transferId).find(transferDoubleListLi).eq(j).text()
                        .substr(0, $(listSearchId).val().length).toLowerCase() == $(listSearchId).val().toLowerCase()) {
                    $(transferId).find(transferDoubleListLi).eq(j).css('display', 'block');
                }
            }
        });

        /**
         * Group fuzzy query on the left
         */
        $(groupListSearchId).on("keyup", function () {
            // Just type in to show list box
            $(transferId).find(transferDoubleGroupListUl).css('display', 'block');
            // If nothing is filled, keep all displayed
            if ($(groupListSearchId).val() == "") {
                for (var i = 0; i < $(transferId).find(groupCheckboxItem).length; i++) {
                    if (!$(transferId).find(checkboxItem).eq(i).is(':checked')) {
                        //Change group li to display
                        $(transferId).find(transferDoubleGroupListLiUlLi).eq(i).parent().parent().css('display', 'block');
                        // Change each li under the group to display
                        $(transferId).find(transferDoubleGroupListLiUlLi).eq(i).css('display', 'block');
                    }
                }
                return;
            }

            //If you fill in, hide all options first
            $(transferId).find(transferDoubleGroupListLi).css('display', 'none');
            $(transferId).find(transferDoubleGroupListLiUlLi).css('display', 'none');

            for (var j = 0; j < $(transferId).find(transferDoubleGroupListLiUlLi).length; j++) {
                // Fuzzy matching, display all matching items
                if (!$(transferId).find(groupCheckboxItem).eq(j).is(':checked')
                    && $(transferId).find(transferDoubleGroupListLiUlLi).eq(j).text()
                        .substr(0, $(groupListSearchId).val().length).toLowerCase() == $(groupListSearchId).val().toLowerCase()) {
                    // Change group li to display
                    $(transferId).find(transferDoubleGroupListLiUlLi).eq(j).parent().parent().css('display', 'block');
                    $(transferId).find(transferDoubleGroupListLiUlLi).eq(j).css('display', 'block');
                }
            }
        });

        /**
         * Fuzzy query on the right
         */
        $(selectedListSearchId).keyup(function () {
            //Just type in to show list box
            $(transferId).find(transferDoubleSelectedListUl).css('display', 'block');

            // If nothing is filled, keep all displayed
            if ($(selectedListSearchId).val() == "") {
                $(transferId).find(transferDoubleSelectedListLi).css('display', 'block');
                return;
            }
            $(transferId).find(transferDoubleSelectedListLi).css('display', 'none');

            for (var i = 0; i < $(transferId).find(transferDoubleSelectedListLi).length; i++) {
                // Fuzzy matching, display all matching items
                if ($(transferId).find(transferDoubleSelectedListLi).eq(i).text()
                        .substr(0, $(selectedListSearchId).val().length).toLowerCase() == $(selectedListSearchId).val().toLowerCase()) {
                    $(transferId).find(transferDoubleSelectedListLi).eq(i).css('display', 'block');
                }
            }
        });
    }

    /**
     * List rendering on the left
     * @param currentTimeStr
     * @param data
     * @returns {string}
     */
    function generateLeftList(currentTimeStr, data, itemName, valueName) {
        var listHtmlStr = "";
        for (var i = 0; i < data.length; i++) {
            listHtmlStr = listHtmlStr +
                '<li class="transfer-double-list-li transfer-double-list-li-' + currentTimeStr + '">' +
                '<div class="checkbox-group">' +
                '<input type="checkbox" value="' + data[i][valueName] + '" class="checkbox-normal checkbox-item-' + currentTimeStr + '" id="itemCheckbox_' + i + '_' + currentTimeStr + '">' +
                '<label class="checkbox-name-' + currentTimeStr + '" for="itemCheckbox_' + i + '_' + currentTimeStr + '">' + data[i][itemName] + '</label>' +
                '</div>' +
                '</li>'
        }
        return listHtmlStr;
    }

    /**
     * Grouped list rendering on the left
     * @param currentTimeStr
     * @param data
     * @returns {string}
     */
    function generateLeftGroupList(currentTimeStr, data, itemName, groupListName, groupItemName, valueName) {
        var listHtmlStr = "";
        for (var i = 0; i < data.length; i++) {
            listHtmlStr = listHtmlStr +
                '<li class="transfer-double-group-list-li transfer-double-group-list-li-' + currentTimeStr + '">'
                + '<div class="checkbox-group">' +
                '<input type="checkbox" class="checkbox-normal group-select-all-' + currentTimeStr + '" id="group_' + i + '_' + currentTimeStr + '">' +
                '<label for="group_' + i + '_' + currentTimeStr + '" class="group-name-' + currentTimeStr + '">' + data[i][groupItemName] + '</label>' +
                '</div>';
            if (data[i][groupListName].length > 0) {
                listHtmlStr = listHtmlStr + '<ul class="transfer-double-group-list-li-ul transfer-double-group-list-li-ul-' + currentTimeStr + '">'
                for (var j = 0; j < data[i][groupListName].length; j++) {
                    listHtmlStr = listHtmlStr + '<li class="transfer-double-group-list-li-ul-li transfer-double-group-list-li-ul-li-' + currentTimeStr + '">' +
                        '<div class="checkbox-group">' +
                        '<input type="checkbox" value="' + data[i][groupListName][j][valueName] + '" class="checkbox-normal group-checkbox-item-' + currentTimeStr + ' belongs-group-' + i + '-' + currentTimeStr + '" id="group_' + i + '_checkbox_' + j + '_' + currentTimeStr + '">' +
                        '<label for="group_' + i + '_checkbox_' + j + '_' + currentTimeStr + '" class="group-checkbox-name-' + currentTimeStr + '">' + data[i][groupListName][j][itemName] + '</label>' +
                        '</div>' +
                        '</li>';
                }
                listHtmlStr = listHtmlStr + '</ul>'
            } else {
                listHtmlStr = listHtmlStr + '</li>';
            }
            listHtmlStr = listHtmlStr + '</li>';
        }
        return listHtmlStr;
    }

    /**
     * Get the number of items in the group
     * @param data
     * @returns {number}
     */
    function getGroupNum(data, groupListName) {
        var total_group_num = 0;
        for (var i = 0; i < data.length; i++) {
            var groupData = data[i][groupListName];
            if (groupData.length > 0) {
                total_group_num = total_group_num + groupData.length;
            }
        }
        return total_group_num;
    }


    /**
     * Return the selected item value array
     * @returns {Array}
     */
    function getSelected() {
        //Shuttle box
        var transferId = "#transfer_double_" + inputId;
        var selected = [];
        var transferDoubleSelectedListLi = ".transfer-double-selected-list-li-" + currentTimeStr;

        for (var i = 0; i < $(transferId).find(transferDoubleSelectedListLi).length; i++) {
            // Fuzzy matching, display all matching items
            var value = $(transferId).find(transferDoubleSelectedListLi).eq(i).find(".checkbox-group").find("input").val();
            selected.push(value);
        }
        return selected;
    }

    /**
     * Returns an array of selected item names
     * @returns {Array}
     */
    function getSelectedName() {
        // Shuttle box
        var transferId = "#transfer_double_" + inputId;
        var selected = [];
        var transferDoubleSelectedListLi = ".transfer-double-selected-list-li-" + currentTimeStr;

        for (var i = 0; i < $(transferId).find(transferDoubleSelectedListLi).length; i++) {
            // Fuzzy matching, display all matching items
            var value = $(transferId).find(transferDoubleSelectedListLi).eq(i).find(".checkbox-group").find("label").text();
            selected.push(value);
        }
        return selected;
    }

    /**
     * Render shuttle box
     * @param inputId
     * @param currentTimeStr
     * @returns {string}
     */
    function generateTransfer(inputId, currentTimeStr) {
        var htmlStr =
            '<div class="transfer-double" id="transfer_double_' + inputId + '">'
            + '<div class="transfer-double-header"></div>'
            + '<div class="transfer-double-content clearfix">'
            + '<div class="transfer-double-content-left">'
            + '<div class="transfer-double-content-tabs">'
            + '<div class="tab-item-name tab-item-name-' + currentTimeStr + ' tab-active">Groups</div>'
            + '<div class="tab-item-name tab-item-name-' + currentTimeStr + '">Items</div>'
            + '</div>'

            + '<div class="transfer-double-list transfer-double-list-' + currentTimeStr + ' tab-content-first-' + currentTimeStr + ' tab-content-active">'
            + '<div class="transfer-double-list-header">'
            + '<div class="transfer-double-list-search">'
            + '<input class="transfer-double-list-search-input" type="text" id="groupListSearch_' + currentTimeStr + '" placeholder="Search" value="" />'
            + '</div>'
            + '</div>'
            + '<div class="transfer-double-list-content">'
            + '<div class="transfer-double-list-main">'
            + '<ul class="transfer-double-group-list-ul transfer-double-group-list-ul-' + currentTimeStr + '">'
            + '</ul>'
            + '</div>'
            + '</div>'
            + '<div class="transfer-double-list-footer">'
            + '<div class="checkbox-group">'
            + '<input type="checkbox" class="checkbox-normal" id="groupsSelectAll_' + currentTimeStr + '"><label for="groupsSelectAll_' + currentTimeStr + '" class="group_total_num_' + currentTimeStr + '"></label>'
            + '</div>'
            + '</div>'
            + '</div>'

            + '<div class="transfer-double-list transfer-double-list-' + currentTimeStr + '">'
            + '<div class="transfer-double-list-header">'
            + '<div class="transfer-double-list-search">'
            + '<input class="transfer-double-list-search-input" type="text" id="listSearch_' + currentTimeStr + '" placeholder="Search" value="" />'
            + '</div>'
            + '</div>'
            + '<div class="transfer-double-list-content">'
            + '<div class="transfer-double-list-main">'
            + '<ul class="transfer-double-list-ul transfer-double-list-ul-' + currentTimeStr + '">'
            + '</ul>'
            + '</div>'
            + '</div>'
            + '<div class="transfer-double-list-footer">'
            + '<div class="checkbox-group">'
            + '<input type="checkbox" class="checkbox-normal" id="selectAll_' + currentTimeStr + '"><label for="selectAll_' + currentTimeStr + '" class="total_num_' + currentTimeStr + '"></label>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '</div>'

            + '<div class="transfer-double-content-middle">'
            + '<div class="btn-select-arrow" id="add_selected_' + currentTimeStr + '"><i class="iconfont icon-forward"></i></div>'
            + '<div class="btn-select-arrow" id="delete_selected_' + currentTimeStr + '"><i class="iconfont icon-back"></i></div>'
            + '</div>'
            + '<div class="transfer-double-content-right">'
            + '<div class="transfer-double-content-param">'
            + '<div class="param-item">Selected</div>'
            + '</div>'
            + '<div class="transfer-double-selected-list">'
            + '<div class="transfer-double-selected-list-header">'
            + '<div class="transfer-double-selected-list-search">'
            + '<input class="transfer-double-selected-list-search-input" type="text" id="selectedListSearch_' + currentTimeStr + '" placeholder="Search" value="" />'
            + '</div>'
            + '</div>'
            + '<div class="transfer-double-selected-list-content">'
            + '<div class="transfer-double-selected-list-main">'
            + '<ul class="transfer-double-selected-list-ul transfer-double-selected-list-ul-' + currentTimeStr + '">'
            + '</ul>'
            + '</div>'
            + '</div>'
            + '<div class="transfer-double-list-footer">'
            + '<label class="selected_total_num_' + currentTimeStr + '">0 Item</label>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '<div class="transfer-double-footer">'
            + '</div>'
            + '</div>';
        return htmlStr;
    }

    return {
        transfer: transfer
    }
})($);
