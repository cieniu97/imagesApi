<script>
import axios from "axios";

export default{
data(){
    return{
          images: [],
          activeImage:0,
          position:0,
      };
  },
  methods:{
      nextImage(){
          this.activeImage+=1;
          if (this.activeImage >= this.images.length){
              this.activeImage = this.images.length-1;
          }
      },
      previousImage(){
          this.activeImage-=1;
          if (this.activeImage < 0 ){
              this.activeImage = 0;
          }
      },
      startTimer(){
          setInterval(this.nextImage, 5000);
      },
      touchStarted(touchEvent){
          this.position = touchEvent.changedTouches[0].clientX;
      },
      touchEnded(touchEvent){
          if(touchEvent.changedTouches[0].clientX < this.position){
              this.nextImage();
          }
          else{
              this.previousImage();
          }
      },
      async getImages(){
        const response = await axios.get("http://localhost:80/api/v1/images");

        for(let i=0; i<response.data.length; i++){
          this.images[i] = "http://localhost:80/storage/images/"+response.data[i].path;
          if(this.images.length == 20){
            break;
          }
        }
      }
  },
  mounted(){
    this.getImages()
    this.startTimer()
    if (localStorage.activeImage) {

          this.activeImage = localStorage.activeImage;

    }
      
  },
  watch: {
      activeImage(newActiveImage) {
          localStorage.activeImage = newActiveImage;
      }
  }

}

</script>
<style>
  @font-face {
  font-family: "stolzl";
  src: url("/layout/Stolzl-Book.woff") format('woff'),
  url("/layout/Stolzl-Book.woff2") format('woff2');
  }
  @font-face {
  font-family: "stolzl";
  src: url("/layout/Stolzl-Bold.woff") format('woff'),
  url("/layout/Stolzl-Bold.woff2") format('woff2');
  font-weight: bold;
  }
</style>
<template>

  <header>


    <div id="app" style="height: 95vh; width: 95vw;margin-top: 5vh; ">
        <div style="height:85vh; display:flex; justify-content:center;" >
         
        <!-- If I set object-fit:cover then pictures are rounded and fited to screen but images can be cut on portriat mode.
            If I set object-fit:contain then there is always whole image but there are no rounded corners  -->
         <img :src="images[activeImage]" alt="" @touchstart="touchStarted" @touchend="touchEnded" style="max-width:100%; object-fit: cover; border-radius: 25px;">

            

        </div>
        <div style="height: 10vh; display: flex; justify-content: space-between; align-items: center;padding-right: 20px; padding-left: 20px;">
            <div style="width:10vw; display:flex; justify-content:space-around">
            <img src="/layout/arrow-left.png" @click="previousImage" alt="Previous" style="cursor: pointer; padding: 5px; height: 2rem;">
            <img src="/layout/arrow-right.png" @click="nextImage" alt="Next" style="cursor: pointer; padding: 5px; height: 2rem;">
            </div>
            <div>
                <span style="color: #4faa6e; font-size: 2rem; font-family: stolzl;"><b>{{ parseInt(activeImage)+1 }}</b></span> <span style="color: #e7e3e5;font-size: 2rem;font-family: stolzl;">/{{images.length}}</span>
            </div>
            
        </div>
        
    </div>
  </header>


</template>

