<script>
  let variantOptions = "";
  function addVarient (argument) {
    var table = document.getElementById("variant-table");
    var t1=(table.rows.length);
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
      /*cell1.className='abc';
      cell2.className='abc';*/
    row.className = "new-row";
    cell0.className='text-center';
    cell3.className='text-center';
    
    $.ajax({
      type: "GET",
      url: "<?= base_url('get_variant')?>",
      data: "",
      dataType: "json",
      encode: true,
    }).done(function (data) {
      
      var vArray = data.data;
      var cls = "tag"+t1
      /*$.each(vArray,function(k,v){
        variantOptions += '<option value="'+v.id+'">'+v.product_name+'</option>'
      });*/

      
      $('<span class="tabledit-span">'+t1+'</span>').appendTo(cell0)
      $('<select class="form-control form-select var-'+t1+' name="variant['+t1+'][variant_id]" variant_data" data-type="var-'+t1+'">'+vArray+'</select>').appendTo(cell1);
      $('<input type="text" name="variant['+t1+'][attributes]" class="form-control " id="'+cls+'" value="" />').appendTo(cell2);
      $('<a href="javascript:void(0);" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell3); 
      
      $('#'+cls).tagsinput({
            maxTags: 5
        });
    })
  }

  $('.variant_data').select2({
    minimumInputLength: 3
  });

  function addBarcodeSpec (argument) {
    var table = document.getElementById("br-table");
    var t1=(table.rows.length);
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    row.className = "new-row";
    cell4.className='text-center';

    $('<input type="text" name="br['+t1+'][specification]" class="form-control">').appendTo(cell0)
    $('<input type="text" name="br['+t1+'][barcode]" class="form-control">').appendTo(cell1);
    $('<input type="text" name="br['+t1+'][unit]" class="form-control">').appendTo(cell2);
    $('<input type="text" name="br['+t1+'][coefficient]" class="form-control">').appendTo(cell3)
    $('<a href="javascript:void(0);" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell4); 
 
  }

  $(document).ready(function() {
      var tagsInput1 = [];
      var tagsInput2 = [];
      var tagsInput3 = [];
      var del = [];
      var href = window.location.href;
      if(href.includes('edit_item')) {
        var tag1 = '<?= isset($data['tags1'])?$data['tags1']:''; ?>'
        tagsInput1 = tag1.split(',');

        var tag2 = '<?= isset($data['tags2'])?$data['tags2']:''; ?>'
        tagsInput2 = tag2.split(',');
      }

      $(document).on('itemAdded', '.st-tags', function(e) {
        var tagInput = e.item;
        var tag = tagInput;
        del.push(tagInput);
        if (tag !== '') {
          createTableRow(tag);
          tagsInput1.push(tag);
          console.log(tagsInput1)
        }
      });

      $(document).on('itemAdded', '.st-tags-dynamic', function(e) {
        var tagInput = e.item;
        del.push(tagInput);
        var tag = tagInput;
        if (tag !== '') {
          tagsInput2.push(tag);
          console.log(tagsInput2)
          var combinations = getAllTagCombinations(tagsInput1, tagsInput2, tagsInput3);
          updateTagTable(combinations);
        }
      });

      $(document).on('itemAdded', '.st-tags-3', function(e) {
        var tagInput = e.item;
        del.push(tagInput);
        var tag = tagInput;
        if (tag !== '') {
          tagsInput3.push(tag);
          console.log(tagsInput3)
          var combinations = getAllTagCombinations(tagsInput1, tagsInput2, tagsInput3);
          updateTagTable(combinations);
        }
      });

      // Create table row
      function createTableRow(tag) {

        var row = $('<tr>').html('<td>' + tag + '</td>');
        var table = document.querySelector(".variant-item-tbl");

        var t1 = $('.variant-item-tbl tbody tr.new-row').length;

        var rows = "";

        var store = '<?php echo isset($data['encoded_store'])?$data['encoded_store']:""; ?>'
        var stArray = JSON.parse(store);
        $.each(stArray,function(k,v){
        
         rows += '<tr>'+
            '<td><input type="hidden" value="'+v.id+'" name="items['+t1+'][stores]['+k+'][store_id]"><input type="text" class="form-control store" name="items['+t1+'][stores]['+k+'][store_name]" placeholder="Store" value="'+v.store_name+'" readonly></td>'+
            '<td><input type="text" class="form-control p-retail_price" name="items['+t1+'][stores]['+k+'][retail_price]" placeholder="Retail Price" value=""></td>'+
            '<td><input type="text" class="form-control p-mrp" name="items['+t1+'][stores]['+k+'][mrp]" placeholder="Minimum Price" value=""></td>'+
            '<td><input type="text" class="form-control p-current_inventory" name="items['+t1+'][stores]['+k+'][current_inventory]" placeholder="Current Inventory" value=""></td>'+
           '<td class="text-center"><input type="text" class="form-control p-inventory_value" name="items['+t1+'][stores]['+k+'][inventory_value]" placeholder="Inventory Value" value=""></td>'+
           '<td class="text-center"><input type="text" class="form-control p-reorder_point" name="items['+t1+'][stores]['+k+'][reorder_point]" placeholder="ReOrder Point" value=""></td>'+
          '</tr>';
        });

        var html = '<tr class="item new-row">'+
        '<td style="padding-left:10px;"><input type="hidden" class="v_name" name="items['+t1+'][name]" value="'+tag+'"><span class="exploder fa fa-angle-right" data-toggle="collapse" data-id="'+t1+'" data-target="#cat'+t1+'" class="accordion-toggle"></span> <span class="variant">'+tag+'</span></td>'+
        '<td><input type="text" class="form-control" name="items['+t1+'][sku]" value="" placeholder="SKU"></td>'+
        '<td><input type="text" class="form-control" name="items['+t1+'][supply_price]" placeholder="Supply Price"></td>'+
        '<td><input type="text" class="form-control" name="items['+t1+'][mrp_percent]" placeholder="Markup(%)"></td>'+
        '<td><input type="text" class="form-control" name="items['+t1+'][retail_price]" placeholder="Retail Price"></td>'+
        '<td><input type="text" class="form-control" name="items['+t1+'][mrp]" placeholder="MRP"></td>'+
        '<td class="text-center"><input type="checkbox" checked value="1" data-size="sm" data-color="danger" name="items['+t1+'][status]" class="switchery" id="sw-'+t1+'"/></td>'+
        '<td class="text-center"><a href="javascript:void(0);" data-id="" class="transh-icon-color deleteVariant" data-table="variant_items"><i class="fa fa-trash-o"></i></a></td></tr>'+
        '<tr id="cat'+t1+'" class="collapse">'+
          '<td colspan="8" style="padding: 1rem 1rem">'+
            '<table class="table table-striped table-bordered variant-item-pr">'+
              '<thead>'+
                '<tr>'+
                  '<th>Store</th>'+
                  '<th>Retail Price</th>'+
                  '<th>Min. Retail Price</th>'+
                  '<th>Current Inventory</th>'+
                  '<th>Inventory Value</th>'+
                  '<th>ReOrder Point</th>'+
                '</tr>'+
              '</thead>'+
              '<tbody>'+rows+'</tbody></table></td></tr>';

        $('.tag-table-body').append(html);

        var elem1 = document.querySelector('#sw-'+t1);

        var a, r = ""

        r = "switchery switchery-small";
        a = "#DA4453";
        new Switchery(elem1, {
          className: r,
          color: a
        })
      }

      // Get all combinations of tags
      function getAllTagCombinations(tags1, tags2, tags3, tagsDynamic = []) {
        var combinations = [];
        $.each(tags1, function(index1, tag1) {
          if (tags2.length > 0) {
            $.each(tags2, function(index2, tag2) {
              if(tags3.length > 0) {
                $.each(tags3, function(index3, tag3) {
                  var combination = tag1 + ' ' + tag2 + ' ' + tag3;
                  combinations.push(combination);
                });
              } else {
                var combination = tag1 + ' ' + tag2;
                combinations.push(combination);
              }
            });
          } else {
            combinations.push(tag1);
          }
        });

        if (tagsDynamic.length > 0) {
          var updatedCombinations = [];
          $.each(combinations, function(index, combination) {
            $.each(tagsDynamic, function(indexDynamic, tagDynamic) {
              var updatedCombination = combination + ' ' + tagDynamic;
              updatedCombinations.push(updatedCombination);
            });
          });
          return updatedCombinations;
        }

        return combinations;
      }

      // Update tag table
      function updateTagTable(combinations) {

        var tbody = $('.tag-table-body').children().remove().clone();
        var href = window.location.href;
        if(href.includes('edit_item')) {
          $("#pr-variance-tbl tbody").html('');
          $("#pr-variance-tbl tbody").append(tbody);
        }
        $('.tag-table-body').empty();
        var dt = $("#pr-variance-tbl tbody").html();

        $.each(combinations, function(index, combination) {
          var flg = 0;
          var mainTr = '';
          var storeTr = '';
          $('tr.item').each(function(k,v){
              var table = document.querySelector(".variant-item-tbl");
              var t1 = table.rows.length;

              var self = $(this);
              var item = self.children('td').children('span.variant').text().trim();

              if(item == combination) {
                flg = 1;
                mainTr = self;
                var i = 0;
                mainTr.children('td').each(function(){ 
                  if(i == 0) {
                    var id = $(this).find('.v_id');
                    var n1 = id.attr('name');
                    if(n1 != undefined) {
                      id.attr('name',n1.replace(/\d+/,t1));
                    }
                    var vname = $(this).find('.v_name');
                    var n2 = vname.attr('name');
                    if(n2 != undefined) {
                      vname.attr('name',n2.replace(/\d+/,t1));
                    }
                    $(this).find('span.exploder').attr('data-id',t1)
                    $(this).find('span.exploder').attr('data-target','#cat'+t1)
                  } else if(i == 7){

                  } else {
                    var input = $(this).find(':input');
                    var o = input.attr('name');
                    input.attr('name',o.replace(/\d+/,t1))
                  }
                i++;
                });

                var next = self.next('tr');
                next.attr('id','cat'+t1)
                next.find(":input").each(function(){
                  var o = $(this).attr('name'); 
                  $(this).attr('name',o.replace(/\d+/,t1));
                });
                storeTr = next;
                return;
              }
          })
          if(flg == 1) {
            $('.tag-table-body').append(mainTr);
            $('.tag-table-body').append(storeTr);
          } else {
            createTableRow(combination);
          }
        });
      }

      $(document).on('itemRemoved','.st-tags',function(e){
        var index = tagsInput1.indexOf(e.item);
        if (index >= 0) {
          tagsInput1.splice( index, 1 );
        }

        var combinations = getAllTagCombinations(tagsInput1, tagsInput2, tagsInput3);

        var tbody = $('.tag-table-body').children().remove().clone();

        var href = window.location.href;
        if(href.includes('edit_item')) {
          $("#pr-variance-tbl tbody").append(tbody);
        }
        $('.tag-table-body').empty();
        /*$('tr.item').each(function(){
          var index = $(this).children('td').children('span.exploder').attr('data-id');
          $(this).append('<input type="hidden" class="isDelete" name="items['+index+'][is_delete]" value="1">');
        })*/
        $.each(combinations, function(index, combination) {
          var flg = 0;
          var mainTr = '';
          var storeTr = '';
          $('tr.item').each(function(){
              var table = document.querySelector(".variant-item-tbl");
              var t1 = table.rows.length;

              var self = $(this);
              var item = self.children('td').children('span.variant').text().trim();

              if(item == combination) {

                flg = 1;
                mainTr = self;
                var i = 0;
                /*var idl = mainTr.children('.isDelete');
                var nl = idl.attr('name');
                if(nl != undefined) {
                  idl.attr('name',nl.replace(/\d+/,t1));
                  idl.val('0')
                }*/
                mainTr.children('td').each(function(){ 
                  if(i == 0) {
                    var id = $(this).find('.v_id');
                    var n1 = id.attr('name');
                    if(n1 != undefined) {
                      id.attr('name',n1.replace(/\d+/,t1));
                    }
                    var vname = $(this).find('.v_name');
                    var n2 = vname.attr('name');
                    if(n2 != undefined) {
                      vname.attr('name',n2.replace(/\d+/,t1));
                    }
                    $(this).find('span.exploder').attr('data-id',t1)
                    $(this).find('span.exploder').attr('data-target','#cat'+t1)
                  } else if(i == 7){

                  } else {
                    var input = $(this).find(':input');
                    var o = input.attr('name');
                    input.attr('name',o.replace(/\d+/,t1))
                  }
                i++;
                });

                var next = self.next('tr');
                next.attr('id','cat'+t1)
                next.find(":input").each(function(){
                  var o = $(this).attr('name'); 
                  $(this).attr('name',o.replace(/\d+/,t1));
                });
                storeTr = next;
                return;
              }
          })
          if(flg == 1) {
            $('.tag-table-body').append(mainTr);
            $('.tag-table-body').append(storeTr);
          }

        });
        if(!del.includes(e.item)) {      
          setIsDeleteVariantItems()
        } else {
          $('#pr-variance-tbl').children('tbody').html('');
        }  
      });

      $(document).on('itemRemoved','.st-tags-3',function(e){
        var index = tagsInput3.indexOf(e.item);
        if (index >= 0) {
          tagsInput3.splice( index, 1 );
        }

        var combinations = getAllTagCombinations(tagsInput1, tagsInput2, tagsInput3);
        updateTagTable(combinations);        
      });

      $(document).on('itemRemoved','.st-tags-dynamic',function(e){
        var index = tagsInput2.indexOf(e.item);
        if (index >= 0) {
          tagsInput2.splice( index, 1 );
        }
        var combinations = getAllTagCombinations(tagsInput1, tagsInput2, tagsInput3);
        
        var tbody = $('.tag-table-body').children().remove().clone();

        var href = window.location.href;
        if(href.includes('edit_item')) {
          $("#pr-variance-tbl tbody").html('');
          $("#pr-variance-tbl tbody").append(tbody);
        }
        $('.tag-table-body').empty();
        /*$('tr.item').each(function(){
          var index = $(this).children('td').children('span.exploder').attr('data-id');
          $(this).append('<input type="hidden" class="isDelete" name="items['+index+'][is_delete]" value="1">');
        })*/
        $.each(combinations, function(index, combination) {
          var flg = 0;
          var mainTr = '';
          var storeTr = '';
          var a = 0;
          $('tr.item').each(function(k1,v1){
              var table = document.querySelector(".variant-item-tbl");
              var t1 = table.rows.length;

              var self = $(this);
              var item = self.children('td').children('span.variant').text().trim();
              
              if(item == combination) {
                flg = 1;
                mainTr = self;
                var i = 0;
                /*var idl = mainTr.children('.isDelete');
                var nl = idl.attr('name');
                if(nl != undefined) {
                  idl.attr('name',nl.replace(/\d+/,t1));
                  idl.val('0')
                }*/
                mainTr.children('td').each(function(k,v){
                  if(i == 0) {
                    var id = $(this).find('.v_id');
                    var n1 = id.attr('name');
                    if(n1 != undefined) {
                      id.attr('name',n1.replace(/\d+/,t1));
                    }
                    var vname = $(this).find('.v_name');
                    var n2 = vname.attr('name');
                    if(n2 != undefined) {
                      vname.attr('name',n2.replace(/\d+/,t1));
                    }
                    $(this).find('span.exploder').attr('data-id',t1)
                    $(this).find('span.exploder').attr('data-target','#cat'+t1)
                  } else if(i == 7){

                  } else {
                    var input = $(this).find(':input');
                    var o = input.attr('name');
                    input.attr('name',o.replace(/\d+/,t1))
                  }
                i++;
                });

                var next = self.next('tr');
                next.attr('id','cat'+t1)
                next.find(":input").each(function(){
                  var o = $(this).attr('name'); 
                  $(this).attr('name',o.replace(/\d+/,t1));
                });
                storeTr = next;
                return;
              }
              a++
          })
          if(flg == 1) {
            $('.tag-table-body').append(mainTr);
            $('.tag-table-body').append(storeTr);
          }
        });
        if(!del.includes(e.item)) {      
          setIsDeleteVariantItems()
        } else {
          $('#pr-variance-tbl').children('tbody').html('');
        }
      });

      $(document).on('itemRemoved','.st-tags-3',function(e){
        var index = tagsInput3.indexOf(e.item);
        if (index >= 0) {
          tagsInput3.splice( index, 1 );
        }

        var combinations = getAllTagCombinations(tagsInput1, tagsInput2, tagsInput3);
        updateTagTable(combinations);        
      });

      $(document).on('click','.deleteVariant',function(){
        var id = $(this).attr('data-id')
        var ids = [];
        var pId = $('#delVariants').val();
        if(pId != "") {
          ids = pId.split(',')
        }
        console.log(ids)
        var cat = $(this).parents('td').siblings('td').children('span.exploder').attr('data-target');
        if(id != "") {
          ids.push(id);
          var str = ids.join(',')
          $('#delVariants').val(str)
        }
        $(this).parents('td').parents('tr.item').remove();
        $('tr'+cat).remove();
      })
  });

  function setIsDeleteVariantItems()
  {
    var items = $('#pr-variance-tbl').children('tbody').find('tr.item');
    var ids = [];
    var pId = $('#delVariants').val();
    if(pId != "") {
      ids = pId.split(',')
    }
    console.log(ids)
    $.each(items, function(k, v) {
      var id = $(this).children('td').find('.v_id').val();
      ids.push(id);
    })

    var str = ids.join(',')
    $('#delVariants').val(str)
    $('#pr-variance-tbl').children('tbody').html('');
  }

  $('#variant-item-tbl').on('click','.exploder', function (e) {
      var tr = $(this).closest('tr').next('tr');
      console.log(tr)
      $(this).toggleClass("fa-angle-right fa-angle-up");
  });

  function addCompositeItem(argument){
      var table = document.getElementById("composite-item-table");
      var t1=(table.rows.length);
      var row = table.insertRow(t1);
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
      var cell3 = row.insertCell(3);
      var cell4 = row.insertCell(4);
      var cell5 = row.insertCell(5);
      row.className = "new-row";
      cell0.className='text-center';
      cell1.className='text-left';
      cell3.className='text-center form-group';
      cell5.className='text-center';

      $.ajax({
        type: "GET",
        url: "<?= base_url('get_composite')?>",
        data: "",
        dataType: "json",
        encode: true,
      }).done(function (data) {
        var vArray = data.data;

        var category = '<?php echo isset($data['categoryEncData'])?$data['categoryEncData']:""; ?>';
        var catArray = JSON.parse(category);
        var options2 = "<option value=0>Click to select item</option>";
        $.each(catArray,function(k,v){
            options2 += '<option value="'+v.id+'">'+v.category_name+'</option>'
        });

        $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
        $('<select class="form-control form-select combo-'+t1+' composite_data" name="composite['+t1+'][composite_item_id]" data-type="combo-'+t1+'">'+vArray+'</select>').appendTo(cell1);
        $('<input type="number" name="composite['+t1+'][quantity]" class="form-control"></td>').appendTo(cell2);
        $('<input type="checkbox" name="composite['+t1+'][optional]" value="1" id="optional'+t1+'"><label for="optional'+t1+'"></label>').appendTo(cell3);
        $('<select name="composite['+t1+'][category_id]" class="form-control form-select" id="">'+options2+'</select>').appendTo(cell4);
        $('<a href="javascript:void(0);" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell5);

        $('.combo-'+t1).select2({
          minimumInputLength: 2
        });
      })
      
  }

  $('.composite_data').select2({
    minimumInputLength: 2
  });

  $(document).on('change','.variant_data',function(){
    var self = $(this);
    var cls = self.attr('data-type');

      if(self.val() == 'add'){
        /*if(type == 3){
            $('#add-new-composite').modal('show')
        }else{*/
            $('#add-new-variant').modal('show')
            $('.'+cls+' > option[value="0"]').attr('selected','selected');
        // }
    }
  })

  $(document).on('change','.composite_data',function(){
    var self = $(this);
    var cls = self.attr('data-type');
    
    if(self.val() == 'add'){

      $('#add-new-composite').modal('show')
      $('.'+cls+' > option[value="0"]').attr('selected','selected');
  
    }
  })

  $('#addVariant').click(function(){
    $('#add-new-variant').modal('show')
  })
  
  function addRecipeField (argument) {
    var table = document.getElementById("Add-Recipe");
    var t1=(table.rows.length);
    
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    
    row.className = "new-row";
      
    cell0.className='text-center orderControl tableOrder';
    cell1.className='text-center';
    cell2.className='text-center';
    cell3.className='text-center';
    cell4.className='text-center';
    
    var items = '<?php echo isset($data['is_ingredient_items'])?$data['is_ingredient_items']:""; ?>';
    var itemArray = JSON.parse(items);
    var options = "";
    $.each(itemArray,function(k,v){
      options += '<option value="'+v.id+'">'+v.item_name+'</option>'
    });

    $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
    $('<select class="form-control form-border form-select item_id" data-tab="recipe" name="items['+t1+'][item_id]"><option>Click to Select Item</option>'+options+'</select>').appendTo(cell1);
    $('<input class="form-control form-border unit" type="number" name="items['+t1+'][unit]" value=""  >').appendTo(cell2);
    $('<input class="form-control form-border total_cost" type="number" name="items['+t1+'][total_cost]" value=""><input class="form-control form-border cost" type="hidden" name="items['+t1+'][cost]" value=""  >').appendTo(cell3);
    $('<a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell4);
  }

  function addModifierField () {
    var table = document.getElementById("add-modifier");
    var t1=(table.rows.length);
    
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    var cell6 = row.insertCell(6);
    
    row.className = "new-row";
      
    cell0.className='text-center orderControl tableOrder';
    cell1.className='text-center';
    cell2.className='text-center';
    cell3.className='text-center';
    cell4.className='text-center';
    cell5.className='text-center';
    cell6.className='text-center';

    var items = '<?php echo isset($data['items'])?$data['items']:""; ?>';
    var itemArray = JSON.parse(items);
    var options = "";
    $.each(itemArray,function(k,v){
      options += '<option value="'+v.id+'">'+v.item_name+'</option>'
    });

    var id = 'item_id-'+t1;

    $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0);
    $('<input class="form-control modifier_item" data-tab="recipe" name="items['+t1+'][modifier_item]">').appendTo(cell1);
    $('<select class="form-control form-select select2 item_id '+id+'" data-tab="modifier" name="items['+t1+'][item_id]"><option>Click to Select Item</option>'+options+'</select>').appendTo(cell2);
    $('<input class="form-control form-border unit" type="number" name="items['+t1+'][unit]" value="">').appendTo(cell3);
    $('<input class="form-control form-border cost" type="number" name="items['+t1+'][cost]" value="">').appendTo(cell4);
    $('<input class="form-control form-border total_cost" type="number" name="items['+t1+'][total_cost]" value="">').appendTo(cell5);
    $('<a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell6);

    $('.'+id).select2({
      minimumInputLength: 3,
    });
    /*$("head").append($("<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.css' type='text/css' media='screen' />"));
    $.getScript("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js", function () { 
        $('.'+id).select2();
    })*/
  }

  $('.item_id').select2({
    minimumInputLength: 3,
    // tags: true
  });

  var cURL = window.location.href
  if(cURL.includes('edit_item')) {
    var type = '<?= isset($data['item_type'])?$data['item_type']:''; ?>'

    $('.item-tab-heads').each(function(k,v){
      var tab = $(this);
      if(type !== "" && tab.attr('data-val') !== type) {
        tab.css({'pointer-events':'none'})
      }
    })
  }

  $(document).on('change','.recipe-item',function() {

    let self = $(this);
    let id = self.val();
    
    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/getItemDetail',
        data: {id:id},
        success: function (res) { 
          res = JSON.parse(res);
          if(res.status == "true") {
            var data = res.data;
            console.log(data.supply_price)

            self.parents('td').siblings('td').children('.unit').val(1);
            self.parents('td').siblings('td').children('.cost').val(data.supply_price);
            self.parents('td').siblings('td').children('.total_cost').val(data.supply_price);
            // var quantity = self.parents('td').siblings('td').children('.quantity').val();
            // var price = data.retail_price;

            // self.parents('td').siblings('td').children('.amount').val(quantity*price);
          }
        }
      });

  });

  $(document).on('change','.item_id',function() {

    let self = $(this);
    let id = self.val();
    
    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/getItemDetail',
        data: { id:id},
        success: function (res) { 
            res = JSON.parse(res);
          if(res.status == "true") {
            var data = res.data;

            self.parents('td').siblings('td').children('.unit').val(1);
            self.parents('td').siblings('td').children('.cost').val(data.supply_price);
            self.parents('td').siblings('td').children('.total_cost').val(data.supply_price*1);
          }
        }
      });
  });

  $(document).on('keyup','.unit',function() {
      let self = $(this);
      let unit = self.val();

      let price = self.parents('td').siblings('td').children('.cost').val();
      if(price != '') {
        setTimeout(function(){
        self.parents('td').siblings('td').children('.total_cost').val(price*unit);
        },500);
      }
  });

  $('.p-markup').on("keyup", function(){
      var self = $(this),
          supplyPr = self.parents('td').siblings('td').children('.p-supply_price').val(),
          markup = parseFloat(self.val());
      if(supplyPr != "") {
        var net = (parseFloat(supplyPr)*parseFloat(markup))/100;
        var retPr = parseFloat(supplyPr)+parseFloat(net);
        self.parents('td').siblings('td').children('.p-retail_price').val(retPr);
      }
  });
  $('.p-retail_price').on("keyup", function(){
      var self = $(this),
          supplyPr = self.parents('td').siblings('td').children('.p-supply_price').val(),
          retPr = self.val();

      if(supplyPr !== "" && retPr !== "") {
        var net = parseFloat(retPr) - parseFloat(supplyPr);
        self.parents('td').siblings('td').children('.p-markup').val(net);
      }else{
        self.parents('td').siblings('td').children('.p-markup').val('');
      }
  });
  $('.p-current_inventory').on("keyup",function(){
    var qty = $(this).val(),
        supply_price = $(this).parents('td').siblings('td').children('.p-supply_price').val(),
        total = (parseFloat(supply_price))*(parseFloat(qty));
    if(supply_price != "") {
      $(this).parents('td').siblings('td').children('.p-inventory_value').val(total);
    }
  });
  $(document).on('keyup','.p-mrp_percent',function() {
    var self = $(this);
    var mrp_per = self.val();
    var retailPr = parseFloat(self.parents('td').siblings('td').children('.p-retail_price').val());
    cMrp = retailPr*(parseFloat(mrp_per)/100);
    totalMrp =  parseFloat(retailPr) - cMrp;
    self.parents('td').siblings('td').children('.p-mrp').val(totalMrp);
  });
  $('.p-supply_price').on("keyup",function(){
    var self = $(this),
        supply_price = self.val(),
        mrp_per = parseFloat(self.parents('td').siblings('td').children('.p-mrp_percent').val()),
        markup = parseFloat(self.parents('td').siblings('td').children('.p-markup').val()),
        current_inventory = self.parents('td').siblings('td').children('.p-current_inventory').val(),
        netMrk = (parseFloat(supply_price)) * (parseFloat(markup)/100),
        retail_price = parseFloat(supply_price)+parseFloat(netMrk),
        invtValue = (parseFloat(supply_price))*(parseFloat(current_inventory));
    if(!isNaN(mrp_per)) {  
      var cMrp = (parseFloat(supply_price))*(parseFloat(mrp_per)/100);
          mrpTotal =  parseFloat(supply_price) + parseFloat(cMrp);
          self.parents('td').siblings('td').children('.p-mrp').val(mrpTotal);
    }

    if(self.val() != "" && !isNaN(markup)) {
      self.parents('td').siblings('td').children('.p-retail_price').val(retail_price);
    }
    if(current_inventory != "") {
      self.parents('td').siblings('td').children('.p-inventory_value').val(parseFloat(invtValue));
    }

    /*$('.p-retail_price').each(function(k,v){
      var t = $(this),
      // mrp = $('#mrp').val();
      
      // netTotal = (parseFloat(supply_price))*(parseFloat(mrp)/100);
      // total =  parseFloat(supply_price) + parseFloat(netTotal);
      // parseFloat($('#minimum_retail_price').val(total)); 
        
    });*/
  });
  $(document).on('keyup','#supply_price',function() {
    var self = $(this);
    var quantity = self.val();
    var supply_price = parseFloat($('#supply_price').val());
    var mrp = parseFloat($('#mrp').val());
    var markup = parseFloat($('#markup').val());
    var current_inventory = parseFloat($('#current_inventory').val());
    
    netTotal = (parseFloat(supply_price)) * (parseFloat(markup)/100);
    retail_price = parseFloat(supply_price)+parseFloat(netTotal);
    parseFloat($('#retail_price').val(retail_price));
    netTotal = (parseFloat(supply_price))*(parseFloat(mrp)/100);
    total =  parseFloat(supply_price) + parseFloat(netTotal);
    parseFloat($('#minimum_retail_price').val(total)); 
      
    netTotal = (parseFloat(supply_price))*(parseFloat(current_inventory));
    parseFloat($('#inventory_value').val(netTotal)); 
  });

  $(document).on('keyup','#markup',function() {
    var self = $(this);
    var quantity = self.val();
    var supply_price = parseFloat($('#supply_price').val());
    var markup = parseFloat($('#markup').val());
    netTotal = (parseFloat(supply_price))*(parseFloat(markup)/100);
    retail_price = parseFloat(supply_price)+parseFloat(netTotal);
   
    parseFloat($('#retail_price').val(retail_price));
  });
  

  $(document).on('keyup','#current_inventory',function() {
    var self = $(this);
    var quantity = self.val();
    var supply_price = parseFloat($('#supply_price').val());
    var current_inventory = parseFloat($('#current_inventory').val());
    netTotal = (parseFloat(supply_price))*(parseFloat(current_inventory));
   
    parseFloat($('#inventory_value').val(netTotal));
  });

  $(document).on('keyup','#mrp',function() {
    var self = $(this);
    var quantity = self.val();
    var supply_price = parseFloat($('#retail_price').val());
    var mrp = parseFloat($('#mrp').val());
    netTotal = (parseFloat(supply_price))*(parseFloat(mrp)/100);
    total =  parseFloat(supply_price) - parseFloat(netTotal);
    parseFloat($('#minimum_retail_price').val(total));
  });  

  //Composite Item Calculation
  $(document).on('keyup','#composite_supply_price',function() {
    var self = $(this);
    var supply_price = parseFloat($('#composite_supply_price').val());
    var mrp = parseFloat($('#composite_mrp').val());
    var markup = parseFloat($('#composite_markup').val());
    var current_inventory = parseFloat($('#composite_current_inventory').val());

    netTotal = (parseFloat(supply_price)) * (parseFloat(markup)/100);
    retail_price = parseFloat(supply_price)+parseFloat(netTotal);
    parseFloat($('#composite_retail_price').val(retail_price));
     
    netTotal = (parseFloat(supply_price))*(parseFloat(mrp)/100);
    total =  parseFloat(supply_price) + parseFloat(netTotal);
    parseFloat($('#composite_minimum_retail_price').val(total)); 

    netTotal = (parseFloat(quantity))*(parseFloat(current_inventory));
    parseFloat($('#composite_inventory_value').val(netTotal));
  });

  $(document).on('keyup','#composite_markup',function() {
    var self = $(this);
    var quantity = self.val();
    var supply_price = parseFloat($('#composite_supply_price').val());
    var markup = parseFloat($('#composite_markup').val());
    netTotal = (parseFloat(supply_price))*(parseFloat(markup)/100);
    retail_price = parseFloat(supply_price)+parseFloat(netTotal);
   
    parseFloat($('#composite_retail_price').val(retail_price));
  });

  $(document).on('keyup','#composite_current_inventory',function() {
    var self = $(this);
    var supply_price = parseFloat($('#composite_supply_price').val());
    var current_inventory = parseFloat($('#composite_current_inventory').val());
    netTotal = (parseFloat(supply_price))*(parseFloat(current_inventory));
   
    parseFloat($('#composite_inventory_value').val(netTotal));
  });

  $(document).on('keyup','#composite_mrp',function() {
    var self = $(this);
    var quantity = self.val();
    var supply_price = parseFloat($('#composite_retail_price').val());
    var mrp = parseFloat($('#composite_mrp').val());
    netTotal = (parseFloat(supply_price))*(parseFloat(mrp)/100);
    total =  parseFloat(supply_price) - parseFloat(netTotal);
    parseFloat($('#composite_minimum_retail_price').val(total));
  });

  function autocomplete(inp, arr) {
    var currentFocus;
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {

          /*check if the item starts with the same letters as the text field value:*/
          if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].substr(val.length);
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' name='test' value='" + arr[i] + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
            b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                closeAllLists();
            });
            a.appendChild(b);
          }
        }
        c = document.createElement("DIV");
            c.setAttribute("class", "font-color add-new-batch");
            c.innerHTML = "<i class='fa fa-plus'></i> Add New Item";
            a.appendChild(c);
    });
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
          currentFocus++;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 38) { //up
          /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
          currentFocus--;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 13) {
          /*If the ENTER key is pressed, prevent the form from being submitted,*/
          e.preventDefault();
          if (currentFocus > -1) {
            /*and simulate a click on the "active" item:*/
            if (x) x[currentFocus].click();
          }
        }
    });
    function addActive(x) {
      if (!x) return false;
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }
    function closeAllLists(elmnt) {
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    document.addEventListener("click", function (e) {
      closeAllLists(e.target);
    });
  }

  function exportItemFunc(type){

    $('.downloadItemsXls').attr('data-type',type);
    $('#export-items-mdl').modal('show');
  }
  $(document).on('click','.downloadItemsXls',function(){
    
    let id = $('#exp-store').val();
    let type = $(this).attr('data-type');
    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/items/itemExportOptions',
        data: {store_id:id,type:type},
        success: function (res) { 
          var r = JSON.parse(res);
          if(r.response.data.length > 0) {
            res = JSON.parse(res);
            if(type == "export_all") {
              var filename=res.response.file_name;
              var data = res.response.data
              const Heading = [
                  ['Store ID','Category','Item Code','Item Name','Barcode','Unit','Purchase Price','Selling Price','Weighed/Non-Weighed Goods','Tax Label','Is Tax Inclusive','Inventory Qty']
              ];
              var ws = XLSX.utils.json_to_sheet(data, { origin: 'A2', skipHeader: true });
              XLSX.utils.sheet_add_aoa(ws, Heading, { origin: 'A1' });
              var wb = XLSX.utils.book_new();
              XLSX.utils.book_append_sheet(wb, ws, "Items");
              XLSX.writeFile(wb,filename);
            }else if(type == "plu_export_csv") {
              // r = JSON.parse(res);
              rows = r.response.data
              let head = Object.keys(rows[0]).join(',') + '\n'; // header row
              let body = rows.map(row => Object.values(row).join(',')).join('\n');

              var e = document.createElement('a');
              e.href = 'data:text/csv;charset=utf-8,' + encodeURI(head + body);
              e.target = '_blank';
              e.download = r.response.file_name;
              e.click();
            }else if(type == "plu_export_txt") {
              // res = JSON.parse(res);
              rows = r.response.data
              let head = Object.keys(rows[0]).join(',') + '\n'; // header row
              let body = rows.map(row => Object.values(row).join(',')).join('\n');

              var e = document.createElement('a');
              e.href = 'data:text/plain;charset=utf-8,' + encodeURI(head + body);
              e.target = '_blank';
              e.download = r.response.file_name;
              e.click();
            }
          } else {
            alertMessage('false','No Data Found');
          }
          $('#export-items-mdl').modal('hide');
        }
      });
  })

  $(document).on('click','#submitSynchronizeBtn',function(){

    var formData = new FormData(document.querySelector("#synchronize_price_form"));
    
    var main_store = document.getElementById('main-store'); // or in jQuery use: select = this;
    if (main_store.value == "") {
      $('.error-msg').text('Please select Store Prices');
      return false;
    } else if(!formData.has("stores[]")) {
        $('.error-msg').text('Please select Synchronized Store');
        return false;      
    } else {
      $('.error-msg').text('');
    }

    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/items/synchronizeStorePrices',
        contentType: false, 
        processData: false,
        data: formData,
        success: function (res) { 
          res = JSON.parse(res);
          $('#synchronize-price-mdl').modal('hide');
          alertMessage(res.status,res.message);
        }
    })
  });

  let checked = 0;
  let select_all_checkboxes = document.getElementById("select_all_stores");
  let delete_checkbox = document.getElementsByClassName("select_store");

  select_all_checkboxes.addEventListener("click", function () {
    for (let i = 0; i < delete_checkbox.length; i++) {
      if (select_all_checkboxes.checked === true) {
        delete_checkbox[i].checked = true;
        checked++;
      } else {
        delete_checkbox[i].checked = false;

        checked--;
      }
    }
  });

  for (let i = 0; i < delete_checkbox.length; i++) {
    delete_checkbox[i].addEventListener("click", function () {
      if (delete_checkbox[i].checked === true) {
        checked += 1;
      } else if (delete_checkbox[i].checked === false) {
        select_all_checkboxes.checked = false;
        checked -= 1;
      }
    });
  }

  $(document).on('click','#delete-all-items',function(){
    swal({
        title: "Are you sure?",
        text: "You want to delete all items!",
        icon: "warning",
        buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: false,
                },
                confirm: {
                    text: "Yes, delete",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
        }
    })
    .then((isConfirm) => {
        if (isConfirm) {
            var type = $(this).attr('data-type');

            $.ajax({
                type: "POST",
                url: '<?= base_url() ?>'+'/items/itemDeleteOptions',
                data: {type:type},
                success: function (res) { 
                  // res = JSON.parse(res);
                  // alertMessage(res.status,res.message);
                  window.location.reload();
                  // swal("Done!", "Items deleted successfully", "success");
                }
            })
        } else {
            $('.swal-overlay').removeClass('swal-overlay--show-modal');
        }
    });
  });

  $('#example-select-all').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
  });

  function batchDelete(){
    swal({
        title: "Are you sure?",
        text: "You want to delete this items!",
        icon: "warning",
        buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: false,
                },
                confirm: {
                    text: "Yes, delete",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
        }
    })
    .then((isConfirm) => {
        if (isConfirm) {
          var type = 'batch_delete';
          var ids = new Array();
          $('input[type=checkbox]').each(function () {
            if (this.checked) {
              ids.push($(this).val());
            }
          });

          $.ajax({
              type: "POST",
              url: '<?= base_url() ?>'+'/items/itemDeleteOptions',
              data: {type:type,ids:ids},
              success: function (res) {
                window.location.reload();
                // swal("Done!", "Items deleted successfully", "success");
              }
          })
        } else {
            $('.swal-overlay').removeClass('swal-overlay--show-modal');
        }
    });

  }

  $('#c-store').change(function(){
      var id = $(this).val();
      $.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/get_location_by_store',
          data: {id:id},
          success: function (res) {
            res = JSON.parse(res);
            if(res.status == "true") {
              var data = res.data;
              $('#copy_from_location').html(data);
              $('#copy_to_location').html(data);
            } else {
              $('#copy_from_location').html('<option value="">Location</option>');
              $('#copy_to_location').html('<option value="">Location</option>');
            }
          }
      });
  });

  function checkCopyLocations()
    {
      var cF = $('#copy_from_location').val();
      var cT = $('#copy_to_location').val();

      if(cF != "" && cT != ""){
        if(cF == cT) {
          alertMessage('false','You can not choose same locations');
          $('#copy_to_location').val('');
          return false;
        }
      }

    }

   /*$('#copy_from_location').change(checkCopyLocations);
   $('#copy_to_location').change(checkCopyLocations);
*/
  $('#copy_items_form').validate({
         rules: {
            main_store: "required",
            copy_from_location: "required",
            copy_to_location: "required"
         },
         messages: {
            main_store: "Please select store",
            copy_from_location: "Please select location to copy from",
            copy_to_location: "Please select location to copy to"
         },
         errorElement: "div",
         errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
         },
         highlight: function (element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
         },
         unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
         },
         submitHandler: function (form) {
            event.preventDefault();
            // $("#btnSubmitCopyLocation").attr("disabled", true);
            var formData = $('#copy_items_form').serialize();

            var cF = $('#copy_from_location').val();
            var cT = $('#copy_to_location').val();

            if(cF != "" && cT != ""){
              if(cF == cT) {
                alertMessage('false','You can not choose same locations');
                $('#copy_to_location').val('');
                return false;
              }
            }

            $.ajax({
              type: "POST",
              url: '<?= base_url() ?>'+'/items/copyLocationItems',
              data: formData,
              dataType: "json",
              encode: true,
            }).done(function (data) {
              alertMessage(data.status, data.message);
              $('#copy-items-mdl').modal('hide');
            });

         }
    });

</script>