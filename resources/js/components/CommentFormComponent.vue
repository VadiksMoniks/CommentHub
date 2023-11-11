<template>
  <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
    <div class="w-[600px] h-[700px] shadow-[rgba(0,0,0,0.4)_0px_30px_90px] bg-white p-4">
      <div  class="flex justify-end">
        <button @click="$emit('update:showCommentForm', !showCommentForm)">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="w-6 h-6 text-gray-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div>
        <ul class="flex space-x-4">
          <li><button @click="addHTML('link')" title="hyper link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="w-4 h-4 ">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
            </svg>
          </button></li>
          <li><button @click="addHTML('code')" title="code block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
            </svg>
          </button></li>
          <li><button @click="addHTML('cursive')" title="cursive text">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 feather feather-italic">
            <line x1="19" y1="4" x2="10" y2="4"></line><line x1="14" y1="20" x2="5" y2="20"></line>
            <line x1="15" y1="4" x2="9" y2="20"></line>
            </svg>
          </button></li>
          <li><button @click="addHTML('strong')" title="strong text">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class=" w-4 h-4 feather feather-bold">
            <path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z">
            </path><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
            </svg>
          </button></li>
          <li>
            <div class="relative"  title="text file">
              <input type="file" id="documentInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="event => onFileChange(event, 'document')">
              <label for="documentInput" class="block relative hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                </svg>
              </label>
            </div>
          </li>
          <li>
            <div class="relative"  title="image">
              <input type="file" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="event => onFileChange(event, 'image')">
              <label for="imageInput" class="block relative hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
              </label>
            </div>
          </li>
        </ul>
      </div>
      <div class="mt-[10%] h-[90%]">
        <textarea  v-model="comment" placeholder="comment" class="w-4/5 h-[50%] resize-none ml-[10%] border border-gray-400"></textarea><br>
        <div class="mt-[10%] flex flex-col items-center">
            <img :src="'./../CAPCHA/' + this.capcha + '.png'" >
            <input type="text" v-model="textFromCapcha" placeholder="Enter text from image" class="mt-[10px] border border-gray-400"><br>
        </div>
        <div class="mt-[8%] flex items-center justify-center">
          <button @click="leaveComment" v-if="this.session==true" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Send comment</button>
          <router-link v-else :to="{ name: 'signin' }">SignIn to send comments</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {

  data(){
    return{
        comment: '',
        document: null,
        image: null,
        textFromCapcha: null
    }
  },

  props: {
    showCommentForm: Boolean,
    session: Boolean,
    user: String,
    commentData: Object,
    answerId: Number,
    capcha: String
  },

  methods:{

    onFileChange(event, field) {
      if(field == 'document'){
         this.document = event.target.files[0];
      }
      else{
        this.image = event.target.files[0];
      }
    },

    leaveComment(){
        const formData = new FormData();
        formData.append('comment', this.comment);
        formData.append('username', this.user);
        formData.append('capcha', this.capcha);
        formData.append('textFromCapcha', this.textFromCapcha);

        if(this.document != null){
          formData.append('document', this.document);
        }
        if(this.image != null){
          formData.append('image', this.image);
        }

        if(this.answerId != null){
          formData.append('answer_to', this.answerId);
        }

        axios.post('http://localhost/CommentHub/public/api/store', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
        .then( response => {
            if(response.status == 200){
                alert(response.data.message);
                this.$emit('update:showCommentForm', false);
                this.$emit('getComments');
            }
            else{
              alert(response.data.message);
            }
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                alert('Something went wrong: '+error.response.data.message);
                
            } 
        });
    },

    addHTML(tag){
      const tags = {
        'link':' <a href="https://PAST THE LINK HERE">DESCRIBE THE DESTINATION</a>',
        'code':' <code>PAST THE CODE HERE</code>',
        'cursive':' <i>PAST TEXT</i>',
        'strong':' <strong>PAST TEXT</strong>'
      };

      this.comment += tags[tag];
    }
  }
};
</script>