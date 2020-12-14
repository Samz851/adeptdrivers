(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).ready(function(){
		function delete_booking(e){
			console.log(e.target);
			e.preventDefault();
			var studentID = $('div.ad-booking-page').attr('data-student-id');
			var booking_id = $(e.target).attr('data-ad-booking');
			var data = {
				'action' : 'ad_delete_student_booking',
				'student_id': studentID,
				'booking_id': booking_id
			}

			$.post(ajaxurl.ajax_url, data, response => {
				if(response.success){
					$(e.target).closest('tr').remove();
				}
			})
		}

		$('table.wp-list-table a').on('click', delete_booking);
		
		var bookingInput = $('div.add-bookingdate');
		if($('#datetimepicker1').length > 0){
			setTimeout(() => {
				$('#datetimepicker1').datetimepicker();
			}, 2000);
		}

		var showAddBtn = $('#show-booking');
		showAddBtn.on('click', (e)=>{
			e.preventDefault();
			// e.preventPropagation();
			bookingInput.toggleClass('show');
			
		});

		var submitAddBookingBtn = $('button#submit-student-booking');

		submitAddBookingBtn.on('click', e => {
			var studentID = $('div.ad-booking-page').attr('data-student-id');
			var bookingDateInput = $('#booking-date');

			if(bookingDateInput.val() !== ''){
				// console.log(bookingDateInput.val());

				var data = {
					'action' : 'ad_add_student_booking',
					'student_id' : studentID,
					'booking_date' : bookingDateInput.val()
				}

				$.post(ajaxurl.ajax_url, data, response => {
					console.log(response);
					if(response.success){
						// console.log(response.data);
						if(response.message == 'Booking Confirmed and Saved!'){
							bookingDateInput.val('');
							console.log($('#empty-bookings').parent());
							$('#empty-bookings').parent().remove();
							var row = $('<tr></tr>');
							var table = $('.the-list');
							console.log(table);
							row.append('<td>' + response.booking.booking_date + '</td>');
							let deleteTag = $('<a href="#" data-ad-booking="' + response.booking.job_id + '">Cancel</a>');
							let status = $('<td>Pending | </td>');
							status.append(deleteTag);
							row.append(status);
							deleteTag.on('click', delete_booking);

							table.append(row);

						}
						setTimeout(() => {
							$('div.booking-confirmation').text(response.message).addClass('success');
						}, 3000);

					}else{
						setTimeout(() => {
							$('div.booking-confirmation').html(`<span>${response.message}</span> <span> Please give us a call to book</span>`).addClass('fail');
						}, 6000);
					}
				})
			}

		})
	 })

})( jQuery );
