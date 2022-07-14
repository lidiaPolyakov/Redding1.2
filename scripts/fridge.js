

$(document).ready(()=>{

  let itemNode = function (url, name , date ,daysLeft, amount,id){
    this.url = url;
    this.name =name;
    this.date =date;
    this.daysLeft=daysLeft;
    this.amount = amount;
    this.id =id;
  } 
  let itemArray = new Array();
  
  $.getJSON("json/productList.json", function (data) {
     
    for( let item of data){
      console.log(item);
          const jsonItem = $.parseJSON(item);   
          const newItem = new itemNode(jsonItem.img,jsonItem.name,jsonItem.eDate,jsonItem.daysLeft,jsonItem.amount,jsonItem.id);
          itemArray.push(newItem); 
          document.getElementById("ingrediant-list").innerHTML+= 
          `<div id="${jsonItem.id}" class="container list-parent" data-id="${jsonItem.id}">
          <div class="product row d-flex p-2 align-items-center justify-content-center" data-id="${jsonItem.id}">
              <div class="col-3 d-flex p-2 align-items-center" data-id="${jsonItem.id}">
                <a href="mainobject.php?productId=${jsonItem.id}&amount=${jsonItem.amount}&days=${jsonItem.daysLeft}" data-id="${jsonItem.id}">
                  <img src="${jsonItem.img}" alt="" data-id="${jsonItem.id}"> 
                </a>
               </div>
               <div class="col-3" data-id="${jsonItem.id}">
               ${jsonItem.name}
               </div>
               <div  class="col-3 p-date" data-id="${jsonItem.id}">
                   ${jsonItem.eDate}
               </div>
               <div class="col-1" data-id="${jsonItem.id}">${jsonItem.daysLeft}</div>
                     <div class="col-1" data-id="${jsonItem.id}">
                        <form action="" method="post" id="changeAmountForminput${jsonItem.id}">
                            <input type="number" style="width:50px" name="amount" value="${jsonItem.amount}" data-id="${jsonItem.id}">
                            <input type="hidden" name="prodId" value="${jsonItem.id}" data-id="${jsonItem.id}">
                            <input for="changeAmountForminput${jsonItem.id}" type="submit" class="btn btn-outline-light" id="submitUpdate${jsonItem.id}" data-id="${jsonItem.id}" value="🔄">
                            
                        </form>
                </div>
           </div>
        </div>`;  
   } 
  
   document.getElementById("big-item").innerHTML = `  
   '<section id="item-options" class="d-flex justify-content-around"><h1 >${itemArray[0].name}</h1>
    <section>
      <a class="btn btn-primary" href="mainobject.php?productId=${itemArray[0].id}&amount=${itemArray[0].amount}&days=${itemArray[0].daysLeft}">
      <i class="fa-solid fa-pen-to-square"></i>
     </a> 
     <br>   
   </section>
  </section>
  <section class="text-center" id="big-selected">
      <p> ${ itemArray[0].date }</p>
   </section>
   <section class="text-center"  id="big-selected">
       <a href="mainobject.php?productId=${itemArray[0].id}&amount=${itemArray[0].amount}&days=${itemArray[0].daysLeft}">
           <img  id="big-pic" src= ${itemArray[0].url} alt="selected-item">
          </a> 
          <br> 
          <input type="number" value= "${ itemArray[0].amount}"  style="width:50px">
  </section>' `;

  const listItems  = document.querySelectorAll(".list-parent");
  console.log(listItems);

  for(let node of listItems){

    node.addEventListener("mouseover", function(e){

        let id = e.target.dataset.id;
        const current = findItem(id);
        
        document.getElementById("big-item").innerHTML = `  
        '<section id="item-options" class="d-flex justify-content-around"><h1 >${current.name}</h1>
         <section>
           <a class="btn btn-primary" href="mainobject.php?productId=${current.id}&amount=${current.amount}&days=${current.daysLeft}">
           <i class="fa-solid fa-pen-to-square"></i>
          </a> 
          <br>   
        </section>
       </section>
       <section class="text-center" id="big-selected">
           <p> ${ current.date }</p>
        </section>
        <section class="text-center"  id="big-selected">
            <a href="mainobject.php?productId=${current.id}&amount=${current.amount}&days=${current.daysLeft}">
                <img  id="big-pic" src= ${current.url} alt="selected-item">
               </a> 
               <br> 
               <input type="number" value= "${current.amount}"  style="width:50px">
       </section>' `;
        

    });
  }

  // event listener for update amount 
  const updates = document.querySelectorAll(".btn-outline-light");
  console.log(updates);
  for(let btn of updates){
    btn.addEventListener("click", function(e){
      e.preventDefault();
      updateAmount(e);
    });
  }

}); 

 function findItem(id){
    for(let node of itemArray){
      if(node.id == id){
        return node;
      }
    }
   
 }

 const updateAmount = async (e) => {
       try{
           const formId = e.target.attributes.for.value;
           const selectForm = document.querySelector(`#${formId}`);
            let response = await fetch("updateAmount.php",{
                method:'POST',
                body: new FormData(selectForm),
            });
            console.log("-------");
            const result = await response.json();
            console.log(result);
       }catch(error){
        console.log(error);
       }
      

 }

});