function Tags(element) {
    var DOMParent = element;
    var DOMList;
    var DOMInput;
    var dataAttribute;
    var arrayOfList;
  
    function DOMCreate() {
      var ul = document.createElement('ul');
      var li = document.createElement('li');
      var input = document.createElement('input');
      DOMParent.appendChild(ul);
      DOMParent.appendChild(input); // first child is <ul>
  
      DOMList = DOMParent.firstElementChild; // last child is <input>
  
      DOMInput = DOMParent.lastElementChild;
    }
  
    function DOMRender() {
      // clear the entire <li> inside <ul> 
      DOMList.innerHTML = ''; // render each <li> to <ul>

      if (arrayOfList.length < 1) {
        $('#membership').val(arrayOfList.toString());
      }
  
      arrayOfList.forEach(function (currentValue, index) {
        var li = document.createElement('li');
        li.innerHTML = "".concat(currentValue, " <a>&times;</a>");
        li.querySelector('a').addEventListener('click', function () {
            onDelete(index);
          return false;
        });
        DOMList.appendChild(li);
        setAttribute();
      });
    }
  
    function onKeyUp() {
      DOMInput.addEventListener('keyup', function (event) {
        var text = this.value.trim(); // check if ',' or 'enter' key was press
        var doit = true;
        if (text.includes(',') || event.keyCode == 13) {
          // check if empty text when ',' is remove
          if (text.replace(',', '') != '') {
            // push to array and remove ','
            arrayOfList.push(text.replace(',', ''));
            doit = false;
          } // clear input
  
  
          this.value = '';
        }
  
        DOMRender();
        if (doit) {
            if (arrayOfList.toString() !== '') {
                $('#membership').val(arrayOfList.toString() + "," + text);
            } else {
                $('#membership').val(text);
            }
        }

      });
    }
  
    function onDelete(id) {
        arrayOfList = arrayOfList.filter(function (currentValue, index) {
            if (index == id) {
          return false;
        }
  
        return currentValue;
      });
      DOMRender();
    }
  
    function getAttribute() {
      dataAttribute = DOMParent.getAttribute('data-simple-tags');
      dataAttribute = dataAttribute.split(','); // store array of data attribute in arrayOfList
        if (dataAttribute[0] === '') {
            arrayOfList = [];
            return
        }
        arrayOfList = dataAttribute.map(function (currentValue) {
          return currentValue.trim();
        });
    }
  
    function setAttribute() {
        $('#membership').val(arrayOfList.toString());
        DOMParent.setAttribute('data-simple-tags', arrayOfList.toString());
    }
  
    getAttribute();
    DOMCreate();
    DOMRender();
    onKeyUp();
  } // run immediately
  
  
  (function () {
    var DOMSimpleTags = document.querySelectorAll('.simple-tags');
    DOMSimpleTags = Array.from(DOMSimpleTags);
    DOMSimpleTags.forEach(function (currentValue, index) {
      // create Tags
      new Tags(currentValue);
    });
  })();