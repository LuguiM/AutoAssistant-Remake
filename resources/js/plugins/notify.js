import { toast } from 'vue3-toastify';

const notify = (mensaje, type, theme) => {

    toast(mensaje, {
        "theme": theme || 'colored',
        "type": type,
    }) 
}

export default notify