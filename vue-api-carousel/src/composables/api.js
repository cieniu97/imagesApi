import { ref } from "vue";
import axios from "axios";

axios.defaults.baseURL="http://localhost:80/api/v1/";

export default function useApi(){
    const images = ref([]);

    const getImages = async () => {
        const response = await axios.get("http://localhost:80/api/v1/images");
        images.value=response.data;
    }
    
    return{
        images,
        getImages,
    };
}