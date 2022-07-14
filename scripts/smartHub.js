

 $(document).ready(function() {
    const loader  = document.querySelector('#loader');
     let chart = new CanvasJS.Chart("chartContainer", {     
         animationEnabled: true,
         title: {
             text: "How Much Food Redding Helped You Save",
           
            
         },
         data: [{
             type: "pie",
             startAngle: 240,
             yValueFormatString: "##0.00\"%\"",
             indexLabel: "{label} {y}",
             dataPoints: [
                 {y: 78.91, label: "Consumed"},
                 {y: 21.26, label: "Wasted"}
             ]
         }]
     });
     chart.render();


     //fetch items to screen
     let shoppingArray = new Array();

     const shoppingNode = function (name, price , userId ,itemId){
                    this.name   = name;
                    this.price  = price ;
                    this.userId = userId;
                    this.itemId =itemId;
                   };

  $.getJSON('json/shoppingListItems.json', function (data) {
         for( let item of data){
            console.log(item);
                const jsonItem = $.parseJSON(item);   
                const newItem = new shoppingNode(jsonItem.name,jsonItem.price,jsonItem.item_id,jsonItem.user_id,);
                shoppingArray.push(newItem); 
                document.getElementById("grocery-list-table").innerHTML+=(`
                <tr class="delete-item-form${jsonItem.item_id}">
                        <td id="${jsonItem.item_id}">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" class="btn btn-outline-primary">
                            <div class="ms-3">
                                <p class="fw-bold mb-1">${jsonItem.name}</p>                  
                            </div>
                        </div>
                    </td>                                   
                    <td>
                        <form action="" method="post" id="delete-item-form${jsonItem.item_id}">
                            <button type="submit" for="delete-item-form${jsonItem.item_id}"  class="btn btn-outline-dark opacity-50" id="deleteBtn${jsonItem.item_id}">
                               x
                            </button>
                            <input type="hidden" name="item_id" value="${jsonItem.item_id}">
                        </form>
                    </td>
                 </tr>`);  
         } 

         const deleteBtns = document.querySelectorAll("[id^='deleteBtn']");
         for(let btn of deleteBtns){
           btn.addEventListener("click",function(e){
               e.preventDefault();
               loader.style.display = "block";
               console.log(e.target);
               deleteItem(e);
               location.reload();
           });
         }
         const submitAdd = document.querySelector("#submit");
         submitAdd.addEventListener("click", (e) =>{
            e.preventDefault();
            loader.style.display = "block";
            saveItem(); 
           

         });

         const shortcuts = document.querySelectorAll(".add-item-btn");
         for(let btn of shortcuts){
            btn.addEventListener("click", (e)=>{
                document.getElementById("new-item-input").value = e.target.attributes.value.value;
                submitAdd.click();
            })
         }
        
   }); 

   //insert item with ajax

   const saveItem = async() => {
    try{
        
        const selectForm = document.getElementById("form");
        let response = await fetch('addTheItem.php', {
            method: 'POST',
            body: new FormData(selectForm),
        });
        const result = await response.json();
        console.log(result);

        document.getElementById("grocery-list-table").innerHTML+=(`
        <tr class="delete-item-form${result.itemId}">
                <td id="${result.itemId}">
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="btn btn-outline-primary">
                    <div class="ms-3">
                        <p class="fw-bold mb-1">${result.itemName}</p>                  
                    </div>
                </div>
            </td>                                   
            <td>
                <form action="" method="post" id="delete-item-form${result.itemId}">
                    <button type="submit" for="delete-item-form${result.itemId}"  class="btn btn-outline-dark opacity-50" id="deleteBtn${result.item_id}">
                       x
                    </button>
                    <input type="hidden" name="item_id" value="${result.itemId}">
                </form>
            </td>
         </tr>`); 
         document.getElementById("new-item-input").value = "";
         loader.style.display = "none";
         document.getElementById(`deleteBtn${result.item_id}`).addEventListener("click",function(e){
                                                                    e.preventDefault();
                                                                    loader.style.display = "block";
                                                                    console.log(e.target);
                                                                    deleteItem(e);
                                                                    location.reload();
                                                                    });
        
    }catch(error){
        console.log(error);
    }
   }

   //Delete item with ajax

   const deleteItem = async(e) => {
    try{
        const formId = e.target.attributes.for.value;
        const selectForm = document.querySelector(`#${formId}`);
        let response = await fetch('deleteShoppingItem.php', {
            method: 'POST',
            body: new FormData(selectForm),
        });
        const result = await response.json();
        console.log(result);
        loader.style.display = "none";
    }catch(error){
        console.log(error);
    }
   }

  
});

