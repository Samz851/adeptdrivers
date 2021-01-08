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
		 console.log(user_record);
		/**
		 * Ajax to delete booking
		 * @param {Event} e 
		 */
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
		function sortObject(obj) {
			return Object.keys(obj).sort((a,b) => {return parseInt(b) - parseInt(a)}).reduce(function (result, key) {
				result[key] = obj[key];
				return result;
			}, {});
		}
		/**
		 * Ajax to get agent schedule
		 * @param {Object} data
		 */
		function get_agent_schedule( data, counter ){
			console.log(counter);
			var agentTable = $('table#agent-availability');
			$.post(ajaxurl.ajax_url, data, response => {
				if(response.success){
					var headerGenerated = false;
					var headerData = [];
					var tableHead = agentTable.find('thead').find('tr');
					var tableBody = agentTable.find('tbody');
					if(!tableHead.is(':empty')) tableHead.empty();
					if(!tableBody.is(':empty')) tableBody.empty();
					tableHead.append('<th></th>');
					console.log(response.dates);
					for(const date in response.dates){
						//Generate days rows
						var day = moment(date, 'YYYY-MM-DD').format('dddd');
						var bodyRow = $(`<tr id="${day}" data-date="${date}"></tr>`);
						bodyRow.append(`<td class="row-date">${day} <span>${date}</span></td>`);
						
						tableBody.append(bodyRow);
						var index = 0;
						response.dates[date] = sortObject(response.dates[date]);
						for (const time in response.dates[date]){
							console.log(Object.keys(response.dates[date])[0])
							console.log(response.dates);
							console.log(time);
							if(response.dates[date][time].length > 1){
								for( const slot in response.dates[date][time]){
									if(!headerGenerated){
										headerData.push(`${time}:${response.dates[date][time][slot][0]}`);
										tableHead.append(`<th>${time}:${response.dates[date][time][slot][0]}</th>`);
									}
									var emptyAppended = false
									if(headerData.indexOf(`${time}:${response.dates[date][time][slot][0]}`) !== index){
										if(!emptyAppended){
											var initIndex = index;
											for(let i = initIndex; i < headerData.indexOf(`${time}:${response.dates[date][time][slot][0]}`); i++){
												var td = $(`<td class="time-slot active" data-slot="${headerData[i]}"></td>`);
												td.on('click', time_slot_clicked);
												bodyRow.append(td);
												// index++;
											}
											emptyAppended = true;
										}else{
											var td = $(`<td class="time-slot active block" data-slot="${time}:${response.dates[date][time][slot][0]}"></td>`);
											// index++;

										}
										

										td.on('click', time_slot_clicked);
										bodyRow.append(td);
										index++;
									}else{
										var td = $(`<td class="time-slot active" data-slot="${time}:${response.dates[date][time][slot][0]}"></td>`);
										td.on('click', time_slot_clicked);
										bodyRow.append(td);
									}
									index++;

								}
							}
						}
						headerGenerated = true;

					};
					highlight_student_bookings();

				}
			})
		}

		/**
		 * Event listenere for time slots
		 */
		function time_slot_clicked(e){
			var exam = $('#exam-booking').prop('checked');
			var remove = $(e.target).hasClass('selected');
			$(e.target).closest('tr').find('td.time-slot.selected').each(function(){
				$(this).removeClass('selected');
			})
			$(e.target).closest('tr').siblings().find('td.time-slot.selected').each(function(){
				$(this).removeClass('selected');
			})
			if(!remove){
				if((!$(e.target).next().hasClass('selected') || !$(e.target).prev().hasClass('selected')) && !$(e.target).next().hasClass('block')){
					if(exam){
						$(e.target).toggleClass('selected');
						$(e.target).next().next().next().next().next().toggleClass('selected');
						$(e.target).next().next().next().next().toggleClass('selected');
						$(e.target).next().next().next().toggleClass('selected');
						$(e.target).next().next().toggleClass('selected');
						$(e.target).next().toggleClass('selected');
					}else{
						$(e.target).toggleClass('selected');
						$(e.target).next().next().toggleClass('selected');
						$(e.target).next().toggleClass('selected');
					}
					var end = exam ? $(e.target).next().next().next().next().next() : $(e.target).next().next();
					var value = `${$(e.target).closest('tr').attr('data-date')} ${$(e.target).attr('data-slot')} to ${$(e.target).closest('tr').attr('data-date')} ${end.next().attr('data-slot')}`;
					$('#booking-date').val(value);
				}
			}else{
				$('#booking-date').val();
			}
			console.log($('#booking-date').val());

		}

		/**
		 * Function to highlight student bookings on timetable
		 */
		function highlight_student_bookings(){
			var studentID = $('div.ad-booking-page').attr('data-student-id');
			var student_bookings = [];
			$('tbody.the-list').find('tr').each(function(){
				student_bookings.push($(this).find('td').first().html());
			});
			student_bookings.forEach(function(string, index){
				var string = string.split(' to ')[0];
				var date = string.split(' ')[0];
				var slot = string.split(' ')[1].substring(0, 5);

				var row = $('#agent-availability > tbody ').find(`tr[data-date='${date}']`);
				var firstSlot = row.find(`td[data-slot='${slot}']`);
				firstSlot.addClass('block');
				firstSlot.next().addClass('block');
				firstSlot.next().next().addClass('block');
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
			$('td.time-slot').each(function(){
				$(this).addClass('active');
			})
			/**
			 * Event handler for selected time slot
			 */
			$('#exam-booking').on('change', function(){
				if(!this.checked){
					$('#agent-availability > tbody').find('td.time-slot.selected').each(function(){
						$(this).removeClass('selected');
					})
				}
			})
			// $('td.time-slot').on('click', time_slot_clicked )
			
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

		});
		/**
		 * Initialize datepicker with values
		 */
		var datepicker = $('#date-picker > input');
		var today = moment().format('YYYY-MM-DD');
		var toDate = moment().add(6, 'day').format('YYYY-MM-DD');
		datepicker.val(`${today} to ${toDate}`);

		/**
		 * Initialize availibilty table with one week data
		 */
		if($('div.ad-booking-page').length){
			get_agent_schedule( { action : 'ad_get_agent_schedule', date_range : `${today} to ${toDate}`}, 7 );
		}

		if($('#date-picker > input').length){
			/**
			 * Agent schedule data
			 */
			$('#date-picker > input').dateRangePicker({
				maxDays: 7,
				minDays: 3,
				startDate: today
			})
			.bind('datepicker-change',function(event,obj){
				/* This event will be triggered when second date is selected */
				console.log(obj);
				// obj will be something like this:
				// {
				// 		date1: (Date object of the earlier date),
				// 		date2: (Date object of the later date),
				//	 	value: "2013-06-05 to 2013-06-07"
				// }
				let from = moment(obj.date1);
				let end = moment(obj.date2);
				get_agent_schedule( { action : 'ad_get_agent_schedule', date_range : obj.value}, end.diff(from, 'days')+1 );
			})
			console.log(moment().format('YYYY-MM-DD'));
		}
		
	 });




})( jQuery );
