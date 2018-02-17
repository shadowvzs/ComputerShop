var preventSlide = false;

var group = $("ol.products-menu").sortable({
  group: 'serialization',
  pullPlaceholder: false,
  nested: true,
  //exclude: '.reserved', for test i inserterted a menu what unable to nest but able to move indirectly in vertical direction

  // animation on drop
  onDrop: function  ($item, container, _super) {
    var $clonedItem = $('<li/>').css({height: 0});
    $item.before($clonedItem);
    $clonedItem.animate({'height': $item.height()});

    $item.animate($clonedItem.position(), function  () {
      $clonedItem.detach();
      _super($item, container);
    });
    preventSlide = false;
  },

  // set $item relative to cursor position
  onDragStart: function ($item, container, _super) {
	preventSlide=true;
    var offset = $item.offset(),
        pointer = container.rootGroup.pointer;

    adjustment = {
      left: pointer.left - offset.left,
      top: pointer.top - offset.top
    };

    _super($item, container);
  },
  onDrag: function ($item, position) {
    $item.css({
      left: position.left - adjustment.left,
      top: position.top - adjustment.top
    });
  }
});

$(".hideList").click(function () {
	if (!preventSlide) {
	    $(this).children("ol").stop(false).slideToggle("slow");
	}
});

let getOrder = () => {
	let myList=[];
	let index = 0;
	let id = '0';
	$("ol.products-menu").find("li").each(function() {
		id = $(this).data("id");
		myList[index] = id;
		index++;
	});
	return myList.join(',');
};

$(function () {
	$("#CategoryOrder1").val(getOrder());
});

$( ".formSubmitBTN" ).click(function() {
	$("#CategoryOrder2").val(getOrder());
})
