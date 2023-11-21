import swal from "sweetalert"

export function useFlash() {
	function flash(message, title = 'Success', level = 'success') {
		return swal(title, message, level)
	}

	return { flash }
}
