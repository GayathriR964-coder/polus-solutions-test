<!DOCTYPE html>
<html>
 <head>
  <title>Simple Login System in Laravel</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
 </head>
 <body>
    <template id="master-row">
        <tr>
            <td>
                <input type="text" name="name" class="form-control" />
            </td>
            <td>
                <input type="number" name="quantity" class="form-control line-total quantity" />
            </td>
            <td>
                <input type="text" class="form-control line-total price" aria-label="Amount (to the nearest dollar)">
            </td>
            <td>
                <select class="form-control tax">
                    <option selected="selected">0%</option>
                    <option>1%</option>
                    <option>5%</option>
                    <option>10%</option>
                </select>
            </td>
            <td>
                <label class="total">0</label>
            </td>
            <td>
                <button type="button" class="remove-item-btn btn-danger">-</button>
            </td>
        </tr>
    </template>
  <br />
  <div class="container box">
   <h3 align="center">Invoice Details</h3><br />
   <button type="button" class="btn-primary" id="add-button">+</button>
     <table class="table"  id="invoice-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Tax</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" name="name" class="form-control" />
                </td>
                <td>
                    <input type="number" name="quantity" class="form-control line-total quantity" />
                </td>
                <td>
                    <input type="text" class="form-control line-total price" aria-label="Amount (to the nearest dollar)">
                </td>
                <td>
                    <select class="form-control tax">
                        <option value="0" selected="selected">0%</option>
                        <option value="1">1%</option>
                        <option value="5">5%</option>
                        <option value="10">10%</option>
                    </select>
                </td>
                <td>
                    <label class="total">0</label>
                </td>
            </tr>
        </tbody>
    </table>


    <div class="row col-md-12">
        <label class="col-md-8">Subtotal Tax</label>
        <div class="col-md-4" id="subtotal-taxed">0</div>
    </div>
    <div class="row col-md-12">
        <label class="col-md-8">Subtotal without Tax</label>
        <div class="col-md-4" id="subtotal-without-tax">0</div>
    </div>
    <div class="row col-md-12">
        <label class="col-md-8">Discount</label>
        <div class="col-md-4">
            <input type="number" id="disc-val" name="discount" class="form-control" />
            <select id="discount" class="form-control">
                <option value='percentage' selected="selected">Percentage</option>
                <option value='amount'>Amount</option>
            </select> 
        </div>  
    </div>
    <div class="row col-md-12">
        <label class="col-md-8">Total</label>
        <div class="col-md-4" id="total">0</div>
    </div>
  </div>
  <button type="button" class="btn-primary">Generate Invoice</button>
 </body>
 <script>
    $(document).ready(function() {
       $('#add-button').click(function(){
            var cloneItem = $('#master-row').clone();
            $('#invoice-table').find('tbody').append(cloneItem.html());
                    
            $('.remove-item-btn').click(function(){
                $(this).closest('tr').remove();
            });
            $('.line-total').keyup(function(){
                calculateTotal(this, true);
            });
            $('.tax').change(function(){
                calculateTotal(this, true);
            });
             
       });
       $('#disc-val').keyup(function(){
            calculateTotal(this);
        });
       $('#discount').change(function(){
            calculateTotal(this);
        });
    });
    $('.line-total').keyup(function(){
        calculateTotal(this, true);
    });
    $('.tax').change(function(){
        calculateTotal(this, true);
    });

    function calculateTotal(el, updateRow=false) {
        if (updateRow) {
            var qty = $(el).closest('tr').find('.quantity').val();
            var price = $(el).closest('tr').find('.price').val();
            var tax = $(el).closest('tr').find('.tax').find(":selected").val();
            let lineTotal = (parseInt(qty)*parseInt(price))*(100+parseInt(tax))/100;
            $(el).closest('tr').find('.total').text(lineTotal);
        }
        let subtotalWithTax = 0;
        let subtotalWithoutTax = 0;
        $('#invoice-table').find('tbody tr').each(function () {
            var qty = $(el).closest('tr').find('.quantity').val();
            var price = $(el).closest('tr').find('.price').val();
            var tax = $(el).closest('tr').find('.tax').find(":selected").val();
            let lineTotal = (parseInt(qty)*parseInt(price))*(100+parseInt(tax))/100;
            subtotalWithTax += lineTotal;
            subtotalWithoutTax += parseInt(qty)*parseInt(price);
        });
        $('#subtotal-taxed').text(subtotalWithTax);
        $('#subtotal-without-tax').text(subtotalWithoutTax);
        var discount = 0;
        var selVal = $('#discount').find(":selected").val();
        if (selVal == 'percentage') {
            discount = subtotalWithTax*(parseInt($('#disc-val').val())/100);
        } else {
            discount = parseInt($('#disc-val').val());
        }
        let total = subtotalWithTax - discount;
        $('#total').text(total);
        
    }
 </script>
</html>