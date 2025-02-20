

$(document).ready(function () {
	console.log("Comman js is loaded");

	// Loading table on load
	if(localStorage.getItem("tabName") == '#dashoardTab'){
		
	}else{
		getTable();
	}
});

let baseUrls = $("#baseUrl").val();

// Logout logic is here

function logout() {
	console.log("hello clcik");

	$.ajax({
		url: baseUrls + "logincontroller/logout",
		type: "POST",
		success: function (data) {
			if (data == "success") {
				window.location.href = baseUrls + "pagescontroller/sessionControl";
			}
		},
	});
}

// Changing active state of tabs from this single logic start **********************************

$(document).on("click", ".master-links a", function () {
	let tabId = $(this).attr("id");

	localStorage.setItem("tabName", "#" + tabId);
});

if (localStorage.getItem("tabName")) {
	let storedTab = localStorage.getItem("tabName");
	$(".master-links a").removeClass("activeTab");
	$(`${storedTab}`).addClass("activeTab");
} else {
	$("#dashoardTab").addClass("activeTab");
}

// Changing active state of tabs from this single logic start **********************************

// Form validation with Insert in databse start's here ************

// class which validate fields

class FormValidation {
	constructor(value, errorText, regExp, id) {
		this.value = value;
		this.errorText = errorText;
		this.regExp = regExp;
		this.id = id;
	}

	validation() {
		if (this.regExp.test(this.value)) {
			$(this.id).next(".error").text("");
		} else if (this.value == "") {
			$(this.id).next(".error").text("");
		} else {
			$(this.id).next(".error").text(this.errorText);
		}
	}

	onlyNumbers() {
		if (/^[0-9]+$/.test(this.value)) {
			console.log("good");
		} else {
			let value = $(this.id).val();
			let new_value = value.slice(0, -1);
			$(this.id).val(new_value);
			console.log("Bad");
		}
	}
	decimalNumber() {
		if (/^[0-9.]+$/.test(this.value)) {
			console.log("good");
		} else {
			let value = $(this.id).val();
			let new_value = value.slice(0, -1);
			$(this.id).val(new_value);
			console.log("Bad");
		}
	}
}

// fields for validation

const fileds_for_validation = [
	{
		id: "#nameId",
		errorText: "only characters are allowed and 2 min character",
		regExp: /^[a-zA-Z ]{3,50}$/,
	},
	{
		id: "#invoiceId",
		errorText: "live search field",
		regExp: /^[0-9 ]{0,10}$/,
		onlyNumber: true,
	},
	{
		id: "#searchId",
		errorText: "live search field",
		regExp: /^[0-9 ]{0,10}$/,
		onlyNumber: true,
	},
	{
		id: "#searchClientPhone",
		errorText: "live search field",
		regExp: /^[0-9 ]{0,10}$/,
		onlyNumber: true,
	},
	{
		id: "#searchPhone",
		errorText: "live search field",
		regExp: /^[0-9 ]{0,10}$/,
		onlyNumber: true,
	},
	{
		id: "#clientPhoneId",
		errorText: "Only numbers allowed",
		regExp: /^[0-9]{0,10}$/,
		onlyNumber: true,
	},
	{
		id: ".amountAddId",
		errorText: "Only numbers allowed",
		regExp: /^[0-9.]+$/,
		decimalNumber: true,
	},
	{
		id: "#totalAmount",
		errorText: "Only numbers allowed",
		regExp: /^[0-9.]+$/,
		decimalNumber: true,
	},
	{
		id: "#itemNameId",
		errorText: "only characters are allowed and 2 min character",
		regExp: /^[a-zA-Z- ]{2,50}$/,
	},
	{
		id: ".itemAddId",
		errorText: "only characters are allowed and 2 min character",
		regExp: /^[a-zA-Z- ]{0,50}$/,
	},
	{
		id: ".itemPriceAddId",
		errorText: "only numbers are allowed",
		regExp: /^[0-9]+$/,
		decimalNumber: true,
	},
	{
		id: "#clientNameId",
		errorText: "only characters are allowed",
		regExp: /^[a-zA-Z ]{0,50}$/,
	},
	{
		id: "#clientPhoneId",
		errorText: "Invalid phone number",
		regExp: /^[0-9]{10}$/,
	},
	{
		id: "#invoice_numberId",
		errorText:
			"Only numbers and charters are allowed and max length is 10 and min length is 3",
		regExp: /^[a-zA-Z0-9]{3,10}$/,
	},
	{
		id: "#descriptionId",
		errorText: "min 3 character and max 100",
		regExp: /^[a-zA-Z0-9%-@$ ]{3,150}$/,
	},
	{
		id: "#priceId",
		errorText: "only numbers are allowed",
		regExp: /^[0-9. ]+$/,
		decimalNumber: true,
	},
	{
		id: "#emailId",
		errorText: "Invalid email",
		regExp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,70}$/,
	},
	{
		id: "#clientEmailId",
		errorText: "Invalid email",
		regExp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,70}$/,
	},
	{
		id: "#passwordId",
		errorText:
			"1 Uppercase , 1 special character , min length 8 is required and max length is 15",
		regExp:
			/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/,
	},
	{
		id: "#phoneId",
		errorText: "Invaid phone number",
		regExp: /^[0-9]{10}$/,
		onlyNumber: true,
	},
	{
		id: ".quantityAddId",
		errorText: "Only numbers are allowed",
		regExp: /^[0-9]+$/,
		onlyNumber: true,
	},
	{
		id: "#imageId",
		errorText: "Invalid format",
		regExp: /(\.jpg|\.jpeg|\.png|\.gif)$/i,
	},
	{
		id: "#stateId",
		errorText: "Field is reuired",
		regExp: /^[0-9]+$/,
	},
	{
		id: "#districtId",
		errorText: "Field is reuired",
		regExp: /^[0-9]+$/,
	},
	{
		id: "#pincodeId",
		errorText: "Only numbers are allowed and lenght must be 6 only",
		regExp: /^[0-9]{6}$/,
		onlyNumber: true,
	},
	{
		id: "#addressId",
		errorText: "Invalid address",
		regExp: /^[a-zA-Z0-9\s,'-]*$/,
	},
	{
		id: "#clientAddressId",
		errorText: "Invalid address",
		regExp: /^[a-zA-Z0-9\s,'-]*$/,
	},
	{
		id: "",
		name_: "languages",
	},
	{
		id: "",
		name_: "gender",
	},
];

// here data goes and create object for class

fileds_for_validation.map((ele) => {
	if (!ele.id == "") {
		$(ele.id).on("input", function () {
			let value = $(ele.id).val().trim();

			let validateObj = new FormValidation(
				value,
				ele.errorText,
				ele.regExp,
				ele.id
			);

			validateObj.validation();
			if (ele.onlyNumber) {
				validateObj.onlyNumbers();
			}
			if (ele.decimalNumber) {
				validateObj.decimalNumber();
			}
		});
	} else {
		$(`input[name=${ele.name_}]`).on("input", function () {
			if ($(`input[name=${ele.name_}]:checked`).length > 0) {
				$(".check-error").text("");
			} else {
				$(".check-error").text("field is required");
				console.log("bad");
			}
		});
	}
});

// filed required
$(document).on("input", "#tableData input, #tableData select", function () {
	if ($(this).is("input[name=id]")) {
		return; // This will skip the current loop for id
	}
	if (
		$(".add-user").hasClass("d-none") &&
		$("input:password") &&
		$("input:file")
	) {
		return; // This will skip the current loop for password and file type
	}
	if ($(this).val() == "" || null || undefined) {
		let filedname = $(this).attr("name");
		filedname = filedname.replace(/_/g, " ");
		filedname = filedname.replace(/[[]]/g, " ");

		$(this)
			.parent(".mb-3")
			.find(".error")
			.text(capitalizeFirstLetter(filedname) + " field is required");
		checkForm = 0;
	}
	if ($(this).is(":checkbox, :radio")) {
		// Check if any checkbox or radio button in the group is checked
		let name = $(this).attr("name"); // Get the name of the checkbox/radio group
		if (name && $("input[name='" + name + "']:checked").length === 0) {
			// If none in the group is checked
			let filedname = $(this).attr("name");
			filedname = filedname.replace(/_/g, " ");
			filedname = filedname.replace(/[[]]/g, " ");

			$(this)
				.parent(".mb-3")
				.find(".error")
				.text(capitalizeFirstLetter(filedname) + " field is required");
			checkForm = 0;
		} else {
			$(this).closest(".form-check").parent().find("small").text("");
		}
	}
});

// Capitalize string

function capitalizeFirstLetter(val) {
	return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

// Adding form data into datable

function sendData() {
	let checkForm = 1;

	$("#tableData input, #tableData select").each(function () {
		if ($(this).is("input[name=id]")) {
			return; // This will skip the current loop for id
		}
		if ($(this).val() == "" || null || undefined) {
			if ($(".add-user").hasClass("d-none") && $("input:file").val() == "") {
				return;
			}
			if (
				$(".add-user").hasClass("d-none") &&
				$("input:password").val() == ""
			) {
				return;
			}
			let filedname = $(this).attr("name");
			filedname = filedname.replace(/_/g, " ");
			filedname = filedname.replace(/[[]]/g, " ");

			$(this)
				.parent(".mb-3")
				.find(".error")
				.text(capitalizeFirstLetter(filedname) + " field is required");
			checkForm = 0;
		}
		if ($(this).is(":checkbox, :radio")) {
			let name = $(this).attr("name");
			if (name && $("input[name='" + name + "']:checked").length === 0) {
				$(this)
					.closest(".form-check")
					.parent()
					.find("small")
					.text("Field is required");
				checkForm = 0;
			}
		}
		if (!$(".error").text() == "") {
			checkForm = 0;
		}
	});

	if (checkForm == 1) {
		let formData = new FormData(tableData);

		if (
			$(".add-user").hasClass("d-none") &&
			!$(".update-user").hasClass("d-none")
		) {
			formData.append("action", "update");
		}

		$.ajax({
			url: baseUrls + "insertcontroller/insert",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				data = JSON.parse(data);
				console.log(data);
				$(".error").text("");

				if (data.errorKeys) {
					for (let i = 0; i < data.errorKeys.length; i++) {
						$(`input[name="${data.errorKeys[i]}"]`)
							.next()
							.text(data.errorValues[i]);

						if (data.errorKeys[i].indexOf("[]") >= 0) {
							$(`input[name="${data.errorKeys[i]}"]`)
								.closest(".form-check")
								.parent()
								.find("small")
								.text(data.errorValues[i]);
							console.log("comming []");
						}
						if (data.errorValues[i] == "") {
							$(`input[name="${data.errorKeys[i]}"]`)
								.next()
								.text("Field is required");
						}
					}
				}
				if (data.imageError) {
					let imageUploadError = data.imageError;
					imageUploadError = imageUploadError.replace("<p>", "");
					imageUploadError = imageUploadError.replace("</p>", "");

					$(".my-backend-error").removeClass("d-none");
					$(".my-backend-error").text(imageUploadError);

					setTimeout(function () {
						$(".my-backend-error").addClass("d-none");
						$(".my-backend-error").text("");
					}, 4000);
				}
				if (data.status == "success") {
					$("#tableData").trigger("reset");

					let change = $("#nav-home-tab");
					let tab = new bootstrap.Tab(change);
					tab.show();

					// setTimeout(function () {
					// 	$(".my-backend-success").addClass("d-none");
					// 	$(".my-backend-success").text("");
					// }, 4000);

					$("#tableData").trigger("reset");
					document.getElementById("myUploadView").src = "";
					getTable();
					if (
						$(".add-user").hasClass("d-none") &&
						!$(".update-user").hasClass("d-none")
					) {
						let text = $("#nav-profile-tab").text();
						let add_text = text.replace("Update", "Add");
						$("#nav-profile-tab").text(add_text);
						$("#userId").val("");
						$(".imageRemoveBtn").remove();
						$(".update-user").addClass("d-none");
						$(".add-user").removeClass("d-none");
						Swal.fire({
							title: "Record updated successfully",
							icon: "success",
							draggable: false,
						});
					} else {
						$(".imageRemoveBtn").remove();
						Swal.fire({
							title: "Record added successfully",
							icon: "success",
							draggable: false,
						});
					}
				}
			},
		});
	} else {
		console.log("validate things");
	}
}

// Form validation with Insert in databse end's here ************

// View Uploaded image start ***********************************************

$("#imageId").on("input", function () {
	$(".imageRemoveBtn").remove();
	if ($("#imageId").val() == "") {
		document.getElementById("myUploadView").src = "";
		$(".imageRemoveBtn").remove();
	} else {
		document.getElementById("myUploadView").src = window.URL.createObjectURL(
			this.files[0]
		);
		$("#myUploadView").after(
			" <button type='button' class='imageRemoveBtn btn btn-danger' onclick='removeImage()' ><i class='bi bi-x-square'></i></button>"
		);
	}
});

// View Uploaded image end ***********************************************

// resetting form on click of homeTab

$("#nav-home-tab").on("click", function () {
	$("#tableData").trigger("reset");
	$("#tableData .error").text("");
	document.getElementById("myUploadView").src = "";
	$(".update-user").addClass("d-none");
	$(".add-user").removeClass("d-none");
	let text = $("#nav-profile-tab").text();
	let add_text = text.replace("Update", "Add");
	$("#userId").val("");
	$("#nav-profile-tab").text(add_text);
	$(".imageRemoveBtn").remove();
	resetMainFormData();
	if (localStorage.getItem("tabName") == "#invoiceTab") {
		generateInvoiceNo();
	}
});

// Table creation Dynamically and Live Search AJAX call start **********************************************************

function getTable() {
	let formData = new FormData(liveSearchForm);

	$.ajax({
		url: baseUrls + "tablecontroller",
		type: "POST",
		data: formData,
		processData: false,
		contentType: false,
		success: function (data) {
			data = JSON.parse(data);
			// console.log(data);
			$(".myDynamicTable").html(data.table);
			$(".dynamicPagination").html(data.pagination);
		},
	});
}

// Table creation Dynamically and Live Search AJAX call end **********************************************************

// Live data Search start *******************************************************

$("#liveSearchForm input").on("input", function () {
	$("#pageId").val(1);
	getTable();
});

// Live data Search end **********************************************************

// Pagination  start *****************************

$(document).on("click", ".my-pagination .li", function () {
	let page = $(this).attr("id");

	$("#pageId").val(page);

	console.log(page);
	getTable();
});

// next button pagination
$(document).on("click", ".next", function () {
	let page = $(this).parents(".my-pagination").find(".active").attr("id");
	let totalPage = $(".my-pagination").attr("id");
	console.log(totalPage);
	page = Number(page) + 1;
	if (page <= totalPage) {
		$("#pageId").val(page);
		getTable();
	}
});

// previous button pagination
$(document).on("click", ".prev", function () {
	let page = $(this).parents(".my-pagination").find(".active").attr("id");
	page = Number(page) - 1;
	console.log(page);
	if (page > 0) {
		$("#pageId").val(page);
		getTable();
	}
});

// Pagination  end *******************************

function resetLoadTable() {
	setTimeout(function () {
		getTable();
	}, 50);
}

// selecting limit of records start **************************************

$("#rowId").on("input", function () {
	let value = $(this).val();
	$("#pageId").val(1);
	$("#limit").val(value);
	getTable();
});

// selecting limit of records end ******************************************

// sorting on table start **********

let sortOrder = "DESC";
$(document).on("click", ".sortingClass", function () {
	if (sortOrder == "DESC") {
		sortOrder = "ASC";
	} else {
		sortOrder = "DESC";
	}
	let sortOn = $(this).data("sort");

	$("#sortOrder").val(sortOrder);
	$("#sortOn").val(sortOn);

	let icon = $(this).find("i");

	if ($(".sortingClass").find("i").hasClass("bi-arrow-up")) {
		$(".sortingClass").find("i").removeClass("bi-arrow-up");
		icon.addClass("bi-arrow-up");
	} else if ($(".sortingClass").find("i").hasClass("bi-arrow-down")) {
		$(".sortingClass").find("i").removeClass("bi-arrow-down");
		icon.addClass("bi-arrow-down");
	}

	if (icon.hasClass("")) {
		icon.addClass("bi-arrow-down");
	} else if (icon.hasClass("bi-arrow-down")) {
		icon.removeClass("bi-arrow-down").addClass("bi-arrow-up");
	} else {
		icon.removeClass("bi-arrow-up").addClass("bi-arrow-down");
	}

	getTable();
});

// sorting on table end **********

// Edit data or  Update data start ******************************************

$(document).on("click", "#editBtn", function () {
	let editId = $(this).data("editid"); // id
	let table_name = $(this).data("tablename"); // table name
	let key = $(this).data("key"); // key
	let change = $("#nav-profile-tab");
	let tab = new bootstrap.Tab(change);
	tab.show();

	$.ajax({
		url: baseUrls + "insertcontroller/edit",
		type: "POST",
		data: { id: editId, table: table_name, key: key },
		success: function (data) {
			console.log(data);
			data = JSON.parse(data);

			if (table_name == "invoice_master") {
				let it = data.item;
				data = data.data;
				console.log(it.length);
				let count = it.length - 1;

				for (let i = 0; i < count; i++) {
					cloneItems();
				}
				for (let i = 0; i < count + 1; i++) {
					$(".itemAddId").eq(i).val(it[i].item_name);
					$(".item_id").eq(i).val(it[i].item_id);
					$(".itemPriceAddId").eq(i).val(it[i].item_price);
					$(".quantityAddId").eq(i).val(it[i].quantity);
					$(".amountAddId").eq(i).val(it[i].amount);
				}
			}

			if ("NAME" in data) {
				data["name"] = data["NAME"];
			}

			// console.log(data);

			// Mapping fileds from name
			Object.keys(data).forEach(function (key) {
				const inputField = $(`#tableData input[name='${key}']`);
				if (
					inputField.attr("type") !== "file" &&
					inputField.attr("type") !== "password"
				) {
					$(
						`#tableData  input[name='${key}'] , #tableData select[name='${key}']`
					).val(data[key]);

					if (key == "state") {
						stateChange();
						setTimeout(function () {
							$(`#tableData select[name='district']`).val(data["district"]);
							console.log($(`#tableData select[name='district']`).val());
						}, 100);
					}
					$(
						`#tableData  input[name='${key}'] , #tableData select[name='${key}']`
					).val(data[key]);
				}
			});

			// setting image in image src
			if (data.image) {
				let imageName = data.image;
				let imagePath = $("#tableData  #imagePath").val();
				$("#myUploadView").attr(
					"src",
					baseUrls + imagePath.slice(2) + "/" + imageName
				);
				$("#myUploadView").after(
					"<button type='button' class='imageRemoveBtn btn btn-danger' onclick='removeImage()' ><i class='bi bi-x-square'></i></button>"
				);
			}
			// changing button from Add data to Update data
			$("#tableData .add-user").addClass("d-none");
			$("#tableData .update-user").removeClass("d-none");
			let text = $("#nav-profile-tab").text();
			let Update_text = text.replace("Add", "Update");
			$("#nav-profile-tab").text(Update_text);
			// console.log(text);
		},
	});
});

// Edit or Update data end ******************************************

// District data on change of state start ***********************************************************

function stateChange() {
	let state_id = $("#stateId").val();

	$.ajax({
		url: baseUrls + "dropdowncontroller/district",
		type: "POST",
		data: { state_id },
		success: function (data) {
			data = JSON.parse(data);
			$(".dynamic_district").remove();
			console.log(data.district_options);
			$("#districtId").append(data.district_options);
		},
	});
}

// District data on change of state end ***********************************************************

// Deleteing data from Database start *******************

$(document).on("click", "#deleteBtn", function () {
	let deleteid = $(this).data("deleteid");
	let key = $(this).data("key");
	let tableName = $(this).data("tablename");

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				swalWithBootstrapButtons.fire({
					title: "Deleted!",
					text: "Your file has been deleted.",
					icon: "success",
				});
				$.ajax({
					url: baseUrls + "tablecontroller/delete",
					type: "POST",
					data: { deleteid: deleteid, tableName: tableName, key: key },
					success: function (data) {
						if(data==1){
							getTable();
						}
					},
					error: function(){
						swalWithBootstrapButtons.fire({
							title: "Cancelled",
							text: "You cannot delete!",
							icon: "error",
						});
					}
				});
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				swalWithBootstrapButtons.fire({
					title: "Cancelled",
					text: "Your data is safe :)",
					icon: "error",
				});
			}
		});
});

// Deleteing data from Databse end *******************

// reset main form data start ***********************************************************

function resetMainFormData() {
	setTimeout(function () {
		document.getElementById("myUploadView").src = "";
		$(".imageRemoveBtn").remove();
		$(".error").text("");
		if ($(".code-container .duplicate-row").length > 1) {
			removeCloneOnHome();
		}
	}, 200);
}
// reset main form data end ***********************************************************

// remove image function start ***********

function removeImage() {
	console.log("remove");
	$("#myUploadView").attr("src", "");
	$(".imageRemoveBtn").remove();
	$(".imageRemoveBtn").remove();
	$("#imageId").val("");
}

// remove image function end ***********

// cloning the item form

function cloneItems() {
	let value = "";

	let prnt = $(".client-detail-container-item");
	let trFrstChild = prnt.find("div.duplicate-row:first-child");
	let cloneChild = trFrstChild.clone();
	cloneChild.find("input[type='text'] , input[type='number']").val("");
	let appendedTo = prnt.find("div.code-container").append(cloneChild);
}

// delete item rows

$(document).on(
	"click",
	".code-container .duplicate-row .delete-row",
	function () {
		if ($(".code-container .duplicate-row").length > 1) {
			$(this).parents(".duplicate-row").remove();
			calculateTotalAmount();
		}
	}
);

// Calculate total amount from all fields
function calculateTotalAmount() {
	let totalAmount = 0;

	$(".amountAddId").each(function () {
		let amount = parseFloat($(this).val()) || 0; // Parse and default to 0 if empty
		totalAmount += amount;
	});

	// Update totalAmount field
	$("#totalAmount").val(totalAmount.toFixed(2));
}

// client name get from auto-complete

let clientAutoComplete = [];

// Initialize autocomplete for client master
$("#clientNameId").autocomplete({
	source: function (request, response) {
		let value = request.term; // `term` is the query the user is typing

		$.ajax({
			url: baseUrls + "dropdowncontroller/client_autocomplete",
			type: "POST",
			data: { name: value },
			success: function (data) {
				data = JSON.parse(data);

				console.log(data);

				clientAutoComplete = [];

				let myArr = data.object;

				// Populate clientAutoComplete with the fetched results
				myArr.map((ele) => {
					clientAutoComplete.push({
						id: ele.id,
						label: ele.NAME, // show up in the dropdown
						value: ele.NAME, // populate in the input field when selected
						phone: ele.phone,
						email: ele.email,
						address: ele.address,
					});
				});

				response(clientAutoComplete);
			},
		});
	},
	select: function (event, ui) {
		$("#clientPhoneId").val(ui.item.phone);
		$("#clientEmailId").val(ui.item.email);
		$("#clientAddressId").val(ui.item.address);
		$("#client_Id").val(ui.item.id);
	},
});

// item name get from auto-complete

let itemAutoComplete = [];

function getitems(e) {
	$(".itemAddId").autocomplete({
		source: function (request, response) {
			let value = request.term;

			let idArr = [];

			$(".item_id").each(function () {
				if (!$(this).val() == "") {
					idArr.push($(this).val());
				}
			});

			let newSet = new Set(idArr);

			idArr = [...newSet];

			console.log(idArr);

			$.ajax({
				url: baseUrls + "dropdowncontroller/item_autocomplete",
				type: "POST",
				data: { item_name: value, arrId: idArr },
				success: function (data) {
					// console.log(data);
					if (data == 0) {
						itemAutoComplete = [];
						return false;
					} else {
						data = JSON.parse(data);
						itemAutoComplete = [];

						// console.log(data.query);

						let myArr = data.object;

						// Populate itemAutoComplete with the fetched results
						myArr.map((ele) => {
							itemAutoComplete.push({
								id: ele.id,
								label: ele.item_name, // show up in the dropdown
								value: ele.item_name, // populate in the input field when selected
								price: ele.item_price,
							});
						});

						response(itemAutoComplete);
					}
				},
			});
		},
		select: function (event, ui) {
			$(this)
				.parents(".duplicate-row")
				.find(".itemPriceAddId")
				.val(ui.item.price);
			$(this).parents(".duplicate-row").find(".item_id").val(ui.item.id);
			$(this).parents(".duplicate-row").find(".quantityAddId").val(1);
			$(this).parents(".duplicate-row").find(".quantityAddId").trigger("input");
			
		},
	});
}

// removing error from client details and if client is empty also removing all details of client

$("#clientNameId").on("input", function () {
	if (!$("#clientNameId").val() == "") {
		console.log(" iam here ");

		$("#clientPhoneId").parent(".mb-3").find(".error").text("");
		$("#clientEmailId").parent(".mb-3").find(".error").text("");
		$("#clientAddressId").parent(".mb-3").find(".error").text("");
		$("#clientAddressId").parent(".mb-3").find(".error").text("");
	} else {
		$("#clientPhoneId").val("");
		$("#clientEmailId").val("");
		$("#clientAddressId").val("");
		$("#client_Id").val("");
	}
});

// removing error on item fields and if item is empty also removing all details of item

$(document).on("input", ".itemAddId", function () {
	if (!$(this).val() == "") {
		$(this).parent(".mb-3").find(".error").text("");
		$(this)
			.parents(".duplicate-row")
			.find(".itemPriceAddId")
			.parent(".mb-3")
			.find(".error")
			.text("");
		$(this)
			.parents(".duplicate-row")
			.find(".quantityAddId")
			.parent(".mb-3")
			.find(".error")
			.text("");
		$(this)
			.parents(".duplicate-row")
			.find(".amountAddId")
			.parent(".mb-3")
			.find(".error")
			.text("");
		$("#totalAmount").parent(".mb-3").find(".error").text("");
		calculateTotalAmount();
	} else {
		$(this).parents(".duplicate-row").find(".itemPriceAddId").val("");
		$(this).parents(".duplicate-row").find(".quantityAddId").val("");
		$(this).parents(".duplicate-row").find(".amountAddId").val("");
		$(this).parents(".duplicate-row").find(".amountAddId").val("");
		$(this).parents(".duplicate-row").find(".item_id").val("");
		calculateTotalAmount();
	}
});

// Total amount of each item
$(document).on("input", ".quantityAddId", function () {
	let price = $(this).parents(".duplicate-row").find(".itemPriceAddId").val();

	let amount = $(this)
		.parents(".duplicate-row")
		.find(".amountAddId")
		.val(parseFloat($(this).val() * price).toFixed(2));

	// Update total amount dynamically whenever the quantity is updated
	calculateTotalAmount();
});

// quntity will never become 0 and less than 0
$(document).on("input", ".quantityAddId", function () {
	if ($(this).parents(".duplicate-row").find(".itemPriceAddId").val() > 0) {
		if ($(this).val() <= 0) {
			$(this).val(1);
			$(this).parents(".duplicate-row").find(".quantityAddId").trigger("input");
		}
	}
});

// invoice data sending

function sendInvoiceData() {
	console.log("sending....");

	let checkForm = 1;

	$("#tableData input, #tableData select").each(function () {
		if ($(this).is("input[name=id]")) {
			return; // This will skip the current loop for id
		}
		if ($(this).val() == "" || null || undefined) {
			if ($(".add-user").hasClass("d-none") && $("input:file").val() == "") {
				return;
			}
			if (
				$(".add-user").hasClass("d-none") &&
				$("input:password").val() == ""
			) {
				return;
			}
			let filedname = $(this).attr("name");
			filedname = filedname.replace(/_/g, " ");
			filedname = filedname.replace(/[[]]/g, " ");

			$(this)
				.parent(".mb-3")
				.find(".error")
				.text(capitalizeFirstLetter(filedname) + " field is required");
			checkForm = 0;
		}
		if ($(this).is(":checkbox, :radio")) {
			let name = $(this).attr("name");
			if (name && $("input[name='" + name + "']:checked").length === 0) {
				$(this)
					.closest(".form-check")
					.parent()
					.find("small")
					.text("Field is required");
				checkForm = 0;
			}
		}
		if (!$(".error").text() == "") {
			checkForm = 0;
		}
	});

	if (checkForm == 1) {
		console.log("sended");

		let formData = new FormData(tableData);

		if (
			$(".add-user").hasClass("d-none") &&
			!$(".update-user").hasClass("d-none")
		) {
			formData.append("action", "update");
		}

		$.ajax({
			url: baseUrls + "InsertController/insertInvoice",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				data = JSON.parse(data);
				if (data.errors) {
					Object.keys(data.errors).forEach(function (key) {
						$(`input[name=${key}]`)
							.parent()
							.find(".error")
							.text(data.errors[key]);
					});
				}
				if (data.success) {
					let change = $("#nav-home-tab");
					let tab = new bootstrap.Tab(change);
					tab.show();

					if (
						$(".add-user").hasClass("d-none") &&
						!$(".update-user").hasClass("d-none")
					) {
						resetMainFormData();
						let text = $("#nav-profile-tab").text();
						let add_text = text.replace("Update", "Add");
						$("#nav-profile-tab").text(add_text);
						$("#userIdd").val("");
						$(".imageRemoveBtn").remove();
						$("#nav-home-tab").trigger("click");
						Swal.fire({
							title: "Record updated successfully",
							icon: "success",
							draggable: false,
						});
					} else {
						resetMainFormData();
						$(".imageRemoveBtn").remove();
						Swal.fire({
							title: "Record added successfully",
							icon: "success",
							draggable: false,
						});
					}
					getTable();
				}
			},
		});
	} else {
		console.log("validate form first");
	}
}

// generating invoice number
function generateInvoiceNo() {
	$.ajax({
		url: baseUrls + "insertcontroller/generateInvoice",
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);

			data = data.invoice_id;

			let invoice_number = "IN" + (Number(data) + 1);

			$("#invoice_numberId").val(invoice_number);
		},
	});
}

if (localStorage.getItem("tabName") == "#invoiceTab") {
	generateInvoiceNo();
}

// calling invoice generater function
$("#nav-profile-tab").on("click", function () {
	if (localStorage.getItem("tabName") == "#invoiceTab") {
		generateInvoiceNo();
	}
});

// remove clone
function removeCloneOnHome() {
	$(".delete-row").trigger("click");
}

// get mail data for sending also downloading pdf in pdfs folder
$(document).on("click", ".mailSend", function () {
	console.log($(this).data("mailid"));
	$("#myMailForm .error").text("");
	let mailId = $(this).data("mailid");

	$("#myMailForm").trigger("reset");

	$.ajax({
		url: baseUrls + "emailcontroller/clientdata",
		type: "POST",
		data: { invoice_id: mailId },
		success: function (data) {
			data = JSON.parse(data);
			$("#recipient_name_id").val(data.name);
			$("#mail_to_id").val(data.email);
			$("#invoice_id_hidden").val(data.invoice_id);
		},
	});

	$.ajax({
		url: baseUrls + "pdfcontroller/mailPdf",
		type: "POST",
		data: { mail: mailId },
		success: function (data) {
			console.log("downloaded pdf");
		},
	});
});

// send mail

function sendMail() {
	let checkForm = 1;

	$("#myMailForm .error").text("");

	$("#myMailForm input , textarea").each(function () {
		if ($(this).val().trim() == "") {
			$(this)
				.next(".error")
				.text($(this).attr("name") + " is required");
			checkForm = 0;
		}
	});

	if (checkForm == 1) {
		let invoiceId = $("#invoice_id_hidden").val();

		let formData = new FormData(myMailForm);

		let pdfFilePath = baseUrls + "pdfs/generated_pdf_" + invoiceId + ".pdf";

		formData.append("pdf_file_path", pdfFilePath);

		$.ajax({
			url: baseUrls + "emailcontroller/mail",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".mail_send_container")
					.html(`<button class="btn btn-success" type="button" disabled>
  					<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
  					<span role="status">Sending...</span>
				</button>`);
			},
			success: function (data) {
				data = JSON.parse(data);
				if (data.success == true) {
					console.log("Mail sended");
					$("#subjectId").val("");
					$("#messageId").val("");
					$(".mail_send_container").html();
					$(".mail_send_container").html(
						`<button type="button" class="btn btn-success" onclick="sendMail()" >Send mail</button>`
					);
					Swal.fire({
						title: "Mail Sended Successfully!",
						icon: "success",
						draggable: false,
					});
				} else {
					Swal.fire({
						title: "Unable to send Mail ",
						icon: "error",
						draggable: false,
					});
				}
			},
		});
	}
}
// side bar hide show
$(".content_wrapper").removeClass("col-md-10").addClass('col');

function hideSideBar() {
	$(".sidebar_wrapper").toggle("slide", { direction: "left" }, 1000);
}

// Dashboard all masert details
function dashboardData() {
	$.ajax({
		url: baseUrls+"tablecontroller/dashboarddata",
		type: "POST",
		success: function(data){
			data = JSON.parse(data);
			$(".bold-number").each(function(){
				let dt = $(this).attr("id");
				$(this).text(data[dt]);

			})
		}
	});
}


if(localStorage.getItem("tabName") == '#dashoardTab'){
	dashboardData();
}

// responsivenes off nav bar
$(window).resize(function() {

	if ($(window).width() < 768) {
  
		$(".user-profile-image").hide();
		$(".user-name").hide();
		$(".sidebar_wrapper").slideUp(1000);
  
	} else {
  
	  $(".user-profile-image").show();
		$(".user-name").show();
  
	}
  
  });
