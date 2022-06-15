
window.onload = function() {

	const path = window.location.pathname.split('/');
	var lang = 'en';
	var langPrefix = '';
	
	path.pop();
	path.shift();
	if (path[0] == 'ja') {
		path.shift();
		lang = 'ja';
		langPrefix = '/ja';
	}

	console.log('workspace javascript has loaded');



	/* START ADMIN PRODUCT FEATURE MANAGER */

	var setRoomFeatureDisplayOrder = function() {
		var displayOrder = [];
		$('.admin-room-feature-list-item').each(function(i){
			displayOrder[i] = $(this).data("room-feature-id");
		});
		var settings = {
			url: "/api/workspace/update-room-feature-display-order/",
			method: "post",
			data: { displayOrder : displayOrder },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$("#admin_room_feature_list").sortable({
		handle: ".drag-handle",
		update: function() { setRoomFeatureDisplayOrder(); }
	});

	var deleteRoomFeature = function(roomFeatureID) {
		var settings = {
			url: "/api/workspace/delete-room-feature/",
			method: "post",
			data: { roomFeatureID : roomFeatureID },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$(document).on('click', '.delete-room-feature', function(){
		var roomFeatureID = $(this).parent().data("room-feature-id");
		$(this).closest('li').remove();
		deleteRoomFeature(roomFeatureID);
	});

	/* END ADMIN PRODUCT FEATURE MANAGER */



	/* START ADMIN PRODUCT SPECIFICATION MANAGER */

	var setRoomSpecificationDisplayOrder = function() {
		var displayOrder = [];
		$('.admin-room-specification-list-item').each(function(i){
			displayOrder[i] = $(this).data("room-specification-id");
		});
		var settings = {
			url: "/api/workspace/update-room-specification-display-order/",
			method: "post",
			data: { displayOrder : displayOrder },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$("#admin_room_specification_list").sortable({
		handle: ".drag-handle",
		update: function() { setRoomSpecificationDisplayOrder(); }
	});

	var deleteRoomSpecification = function(roomSpecificationID) {
		var settings = {
			url: "/api/workspace/delete-room-specification/",
			method: "post",
			data: { roomSpecificationID : roomSpecificationID },
			dataType: "json"
		};
		$.ajax(settings);
	}

	$(document).on('click', '.delete-room-specification', function(){
		var roomSpecificationID = $(this).parent().data("room-specification-id");
		$(this).closest('li').remove();
		deleteRoomSpecification(roomSpecificationID);
	});

	/* END ADMIN PRODUCT SPECIFICATION MANAGER */



};
