document.addEventListener( "DOMContentLoaded", function() {
	var categoryCheckboxes = [].slice.call( document.querySelectorAll( "#taxonomy-category input[type=checkbox]" ) );
	var primarySelect = document.querySelector( "select[name=_pc_primary_category]" );

	/**
	 * Handles toggling the `disabled` state on the primary category `select` input.
	 */
	function toggleSelectState() {
		var options = [].slice.call( primarySelect.getElementsByTagName( "option" ) );

		// There will always be at least one option - the placeholder.
		if ( 1 < options.length ) {
			primarySelect.disabled = false;
		} else {
			primarySelect.disabled = true;
		}
	}

	/**
	 * Adds an `option` to the primary category `select` input.
	 *
	 * @param {string} value The category ID, used as the option value.
	 * @param {string} text  The category name, used as the option text.
	 */
	function addOption( value, text ) {
		var option = "<option value='" + value + "'>" + text + "</option>";

		primarySelect.insertAdjacentHTML( "beforeend", option );
	}

	/**
	 * Removes an `option` from the primary category `select` input.
	 *
	 * @param {string} value The category ID, used to target the proper `option`.
	 */
	function removeOption( value ) {
		[].slice.call( primarySelect.querySelectorAll( "option" ) ).forEach( function( option ) {
			if ( option.value === value ) {
				option.remove();
			}
		} );
	}

	toggleSelectState();

	categoryCheckboxes.forEach( function( checkbox ) {
		checkbox.addEventListener( "change", function() {
			if ( this.checked ) {
				addOption( this.value, this.nextSibling.nodeValue );
			} else {
				removeOption( this.value );
			}

			toggleSelectState();
		} );
	} );
} );
