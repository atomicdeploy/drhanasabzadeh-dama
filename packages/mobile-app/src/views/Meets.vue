<template>
  <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <GDialog v-model="this.loginDialog" max-width="500" >
    <div class="wrapper" style="">
      <div class="content">
        <div style="width: 100%;text-align: center">
          <img style="width:85px " src="../assets/images/needlogin.png">
        </div>
        <div style="width: 100%;text-align: center;font-size: 18px;font-weight: bold;padding: 10px">{{$t('General.loginApplication')}}</div>

        <p style="width: 100%;text-align: center;font-size: 14px;padding: 10px 0 10px 0">
          {{$t('General.loginApplicationDesc')}}
        </p>
      </div>
    </div>
    <div class="row" style="padding: unset;margin-top: 15px ">
      <div @click="this.$router.push({ path: '/mobile' });" style="width: 50%;text-align: center;background: var(--va-basecolor);padding: 10px 0 10px 0;color:white" class="modallogin"> {{$t('General.loginApplicationBtn')}}</div>
      <div @click="this.loginDialog=false" style="width: 50%;text-align: center;background: #dddddd;padding: 10px 0 10px 0" class="modalcancel">{{$t('General.loginApplicationCancel')}}</div>
    </div>
  </GDialog>
  <div v-if="this.getedLink===1" class="overlay">
    <div class="overlay__inner">
      <div class="overlay__content"><span class="spinner"></span></div>
    </div>
  </div>
  <div class="row">
<!--    <p v-if="this.course_type===1" style="font-size: 15px;width: 49%;padding: 3% 3% 3% 3%">{{$t('Meets.courseDetails')}}</p>-->
<!--    <p v-else-if="this.course_type===2" style="font-size: 15px;width: 49%;padding: 3% 3% 3% 3%">{{$t('Meets.videoDetails')}}</p>-->
<!--    <p v-else-if="this.course_type===3" style="font-size: 15px;width: 49%;padding: 3% 3% 3% 3%">{{$t('Meets.podcastDetails')}}</p>-->
<!--    <p v-else-if="this.course_type===4" style="font-size: 15px;width: 49%;padding: 3% 3% 3% 3%">{{$t('Meets.bookDetails')}}</p>-->

    <p v-if="this.course_type>=1" style="font-size: 15px;width: 49%;padding: 3% 3% 3% 3%">{{$t('Meets.details')}}</p>
    <p v-else style="font-size: 15px;width: 49%;padding: 3% 3% 3% 0" ></p>
    <p style="font-size: 13px;width: 49%;padding: 3% 3% 3% 3%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px" />
    </p>
  </div>
  <Loading v-if="this.geted===1"  />
  <div  v-if="this.geted===2" style="margin: 3% 3% 0 3%">
    <div class="mycard" style="width:100%;margin: 5% 0 5% 0;padding: 0 0 3% 0;border-radius: 20px !important;">
      <div class="row"  style="padding: unset" oncontextmenu="return false;">

        <img v-if="this.getedLink!==2 && this.courseCoverType==='pic'" :src="this.baseurl+'/images/course/'+this.courseCoverPic" style="width:100%;border-radius: 20px 15px 0 0 ">
        <video v-else-if="this.getedLink!==2 && this.courseCoverType==='video'" autoplay  controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%">
          <source :src="this.baseurl+'/images/course/'+this.courseCoverPic"  type="video/mp4" />
        </video>


        <audio v-else-if="this.file_type==='audio' && this.play_url!==''" id="myAudio"  @loadedmetadata="this.initializeVideo('audio')" preload="none" autoplay webkit-playsinline playsinline controlsList="nodownload noplaybackrate"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;height: 100px">
          <source :src="this.play_url"  type="audio/mpeg" />
        </audio>
        <video v-else-if="this.play_url!==''" ref="myVideo" id="myVideo"  @loadedmetadata="this.initializeVideo('video')" autoplay  controlsList="nodownload noplaybackrate"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%">
          <source :src="this.play_url"  type="video/mp4" />
        </video>
        <!--          <Artplayer  v-else @get-instance="getInstance" :option="option" :style="style" :info="false" style="border-radius: 10px !important;"/>-->
      </div>
      <p style="padding: 10px 15px 5px 5px;font-size: 13px">{{this.product_name}}</p>
      <div v-if="this.is_driving===0 && this.getedLink===2" class="row" style="margin: 7% 0 5% 0">

        <div @click="this.is_driving=1" style="width: 20%;text-align: center">
          <font-awesome-icon  icon="fa-solid fa-car" />
          <p style="font-size: 9px;margin-top: 5%">{{$t('Meets.driving')}}</p>
        </div>
        <div style="width: 20%;text-align: center">
          <font-awesome-icon size="2x" @click="this.jump('+')" icon="fa-solid fa-rotate-right" />
        </div>
        <div style="width: 20%;text-align: center">
          <font-awesome-icon size="2x" @click="this.playPause()" :icon="this.playIcon" style="color: var(--va-basecolor)"/>
        </div>
        <div style="width: 20%;text-align: center">
          <font-awesome-icon @click="this.jump('-')" size="2x" icon="fa-solid fa-rotate-left" />
        </div>
        <div @click="this.open_speed()" style="width: 20%;text-align: center">
          <font-awesome-icon icon="fa-solid fa-gauge-simple-high" />
          <p v-if="this.play_speed===1" style="font-size: 9px;margin-top: 5%">{{$t('Meets.speed')}}</p>
          <p v-else style="font-size: 9px;margin-top: 5%">{{this.play_speed}}</p>
        </div>
      </div>
      <div v-if="this.is_driving===1 && this.getedLink===2" class="row" style="margin: 7% 0 5% 0">
        <div style="width: 35%;text-align: center">
          <font-awesome-icon size="3x" @click="this.jump('+')" icon="fa-solid fa-rotate-right" />
        </div>
        <div style="width: 30%;text-align: center">
          <font-awesome-icon size="3x" @click="this.playPause()" :icon="this.playIcon" style="color: var(--va-basecolor)"/>
        </div>
        <div style="width: 35%;text-align: center">
          <font-awesome-icon size="3x" @click="this.jump('-')" icon="fa-solid fa-rotate-left" />
        </div>
      </div>
      <div  v-if="this.is_driving===1 && this.getedLink===2" class="row" style="margin: 12% 0 5% 0">
        <div @click="this.is_driving=0" style="width: 50%;text-align: center">
          <font-awesome-icon  icon="fa-solid fa-car" style="color: var(--va-basecolor)"/>
          <p style="font-size: 9px;margin-top: 5%">{{$t('Meets.driving')}}</p>
        </div>
        <div @click="this.open_speed()" style="width: 50%;text-align: center">
          <font-awesome-icon icon="fa-solid fa-gauge-simple-high" />
          <p v-if="this.play_speed===1" style="font-size: 9px;margin-top: 5%">سرعت</p>
          <p v-else style="font-size: 9px;margin-top: 5%">{{this.play_speed}}</p>
        </div>
      </div>
      <div v-if="this.getedLink===2" style="width: 96%;height:1px;background-color: #d0d0d0;margin: 4% 2% 4% 2%"></div>
      <div class="row" style="padding: unset">
        <p style="font-size: 15px;padding: 4% 3% 5% 3%;width: 86%">{{ this.courseName }}</p>

        <font-awesome-icon v-if="this.changeFav===0" @click="this.setFav()" icon="fa-regular fa-bookmark" style="width: 10%;margin:3% 2% 0 2%; color: red;font-size: 20px"/>
        <font-awesome-icon v-else @click="this.setFav()" icon="fa-solid fa-bookmark" style="width: 9%;margin:3% 2% 0 2%; color: red;font-size: 20px"/>
      </div>
      <div class="row"  style="padding: unset;margin:0 3% 0 3%">
        <font-awesome-icon icon="fa-regular fa-clock" style="font-size: 0.85rem;margin:0 0 0 0;color: #636363"/>
        <span style="font-size: 13px;color:#636363;width: 28%;margin: 2px 2px 0 2px">{{ this.courseSection }}</span>
        <font-awesome-icon icon="fa-solid fa-chart-column" style="font-size: 0.85rem;color: #636363;margin-left: 2%;"/>
        <span style="font-size: 13px;color:#636363;width: 30%;margin: 2px 2px 0 2px">{{this.courseParticipants}}</span>
        <Rating :size="'0.75rem'" :rate="5" style="margin-left: 4%"/>
      </div>
      <div class="row" style="padding-right: 0;margin: 10px 0 0 0">
        <div style="width: 56%;margin: 0 3% 0 3%">
          <span style="font-size: 13px;color: #636363">{{ this.courseTeacher }}</span>
        </div>
        <div v-if="this.PriceOffInt===0" style="width: 35%;padding: 0;margin: 1% 0 0 3%">
          <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold;display: block;margin-left: 1%">{{this.courseType}}</div>
        </div>
        <div v-else style="width: 35%;padding: 0;margin: 1% 0 0 3%">
          <div class="row" style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1%"><strike>{{this.PriceOff}}</strike></div>
          <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold; display: block;margin-left: 1%">{{this.courseType}}</div>
        </div>
      </div>
      <div style="width: 96%;height:1px;background-color: #d0d0d0;margin: 4% 2% 4% 2%"></div>
      <button v-if="this.isLogin===false" @click="this.goToInvoice('BuyCourse')" class="buybtn" type="button">
        {{$t('Meets.loginAndViewFiles')}}
      </button>
      <div v-else-if="this.can_buy===2 && this.needSubscription===0" class="row" >
        <va-counter class="my-2"
                    v-model="this.amount"
                    buttons
                    :flat="false"
                    rounded
                    :min="1"
                    manual-input
                    style="margin-left: 5%;width: 49%"
        />
        <button  @click="this.goToInvoice('BuyCourse')" class="buybtncounter" type="button">
          <va-icon class="material-icons">local_mall</va-icon>
          {{$t('Meets.buy')}}
        </button>
      </div>
      <button v-else-if="this.can_buy===0 && this.needSubscription===0" @click="myToast(this.$t('Meets.completedCapacity'),2)" class="compbtn" type="button">
        <va-icon class="material-icons">local_mall</va-icon>
        {{$t('Meets.completedCapacity')}}
      </button>
      <button v-else-if="this.can_buy===3 && this.needSubscription===0"  @click="myToast(this.$t('Meets.comingsoonCourse'),2)" class="compbtn" type="button">
        <va-icon class="material-icons">local_mall</va-icon>
        {{$t('Meets.comingsoon')}}
      </button>
      <button v-else-if="this.buyed===0 && this.needSubscription===0" @click="this.goToInvoice('BuyCourse')" class="buybtn" type="button">
        <va-icon class="material-icons">local_mall</va-icon>
        {{$t('Meets.buy')}}
      </button>
      <button v-else-if="this.buyed===0 && this.needSubscription===1" @click="this.goToPage('/subscription')" class="buybtn" type="button">
        <va-icon class="material-icons">local_mall</va-icon>
        {{$t('Meets.subscriptionBuy')}}
      </button>
      <button v-else-if="this.buyed===1" class="buybtn" type="button">
        <div style="text-align: center;font-size: 14px">{{$t('Meets.activeCourse')}}<va-icon style="width: 32px" class="material-icons">check_cicle</va-icon></div>
      </button>
      <button v-else @click="this.loginDialog=true" class="buybtn" type="button" >
        <va-icon class="material-icons">local_mall</va-icon>
        {{$t('Meets.buy')}}
      </button>


<!--      <p v-if="this.course_type===1" style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">{{$t('Meets.courseIntroduction')}}</p>-->
<!--      <p v-else-if="this.course_type===2" style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">{{$t('Meets.videoIntroduction')}}</p>-->
<!--      <p v-else-if="this.course_type===3" style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">{{$t('Meets.podcastIntroduction')}}</p>-->
<!--      <p v-else-if="this.course_type===4" style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">{{$t('Meets.bookIntroduction')}}</p>-->
      <p v-if="this.course_type>=1" style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">{{$t('Meets.introduction')}}</p>
      <p v-else style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px"></p>



      <div v-if="this.is_short===1" v-html="this.courseShortComment" style="width: 100%;padding: 3%;  line-height: 1.6;">

      </div>
      <div v-else  v-html="this.courseComment" style="width: 100%;padding: 3%;  line-height: 1.6;">
      </div>
      <div v-if="this.is_short===1 && this.courseComment!==this.courseShortComment" @click="this.is_short=0" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;color:#8a8a8a">{{$t('Meets.more')}}</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color:#8a8a8a" class="material-icons">expand_more</va-icon>
        </p>
      </div>
      <div v-else-if="this.is_short===0 && this.courseComment!==this.courseShortComment"  @click="this.is_short=1" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;color:#8a8a8a">{{$t('Meets.less')}}</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color: #8a8a8a" class="material-icons">expand_less</va-icon>
        </p>
      </div>
    </div>
  </div>
  <a href="#meetcomment">
    <button @click="this.moreComment(0)" v-if="this.geted===2 && this.comments.length>0 " class="buybtn" type="button" style="margin-top: unset;margin-bottom: unset">
      <font-awesome-icon style="margin:1px 0 0 5px" icon="fa-solid fa-angle-down" />
      {{$t('Meets.viewComments')}}
    </button>
  </a>
  <div  v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px">
    <p style="padding: 5% 3% 3% 3%;font-weight: bold">{{$t('Meets.listFiles')}}</p>
    <va-accordion v-model="value" style="width: 100%;padding: 0 0 0 0">
      <va-collapse
          v-for="(collapse, index) in collapses"
          :key="index"
          :color="collapse.id===this.meet_ref_link?'#EEEEEE':'#FFFFFF'"
          :header="collapse.title"
          solid="false">
        <div>


          <div v-if="collapse.Type===1 && collapse.Buyed===0 && collapse.PriceInt>0" class="row">
            <button @click="this.goToInvoice('BuyMeet',collapse.id)" class="buymeetbtn" type="button">
              <va-icon class="material-icons">local_mall</va-icon>
              خرید این جلسه - {{collapse.Price}}
            </button>
          </div>


<!--          <div v-if="collapse.Type===1 && collapse.Buyed===0" class="row">-->
<!--            <button class="buyallbtn" type="button">-->
<!--              {{$t('Meets.buyAll')}}-->
<!--            </button>-->
<!--          </div>-->
          <div class="row justify-space-between"  v-for="insub in collapse.sub" :key="insub.id" style="padding: 4%">
            <div  :class="{active_play:insub.id===this.product_ref}">
              <div class="row">
                <va-icon class="material-icons">fiber_manual_record</va-icon>
                <p style="margin-top: 5px">{{insub.content}}</p>
              </div>
              <div class="row">
                <p style="margin-top: 5px;color: #a9a9a9;margin-right: 2%;font-size: 14px">{{insub.amount}}</p>
              </div>
            </div>
            <div v-if="collapse.Buyed===1 && insub.can_download===1"  style="margin-top: 2%;cursor:pointer">
              <a download><va-icon  @click="this.openFile(insub.id,1)" class="material-icons" style="color: var(--va-greencolor);font-size: 30px">download</va-icon></a>&nbsp;
              <va-icon @click="this.playVideo(insub.id,0)" class="material-icons" style="color: var(--va-greencolor);font-size: 30px">play_circle</va-icon>
            </div>

            <div v-else-if="insub.isfile===1" @click="this.openFile(insub.id,0)" style=" margin-top: 2%;cursor:pointer">
              <a download></a><va-icon class="material-icons" style="color: var(--va-greencolor);font-size: 30px">download</va-icon>
            </div>


            <div v-else-if="collapse.Buyed===1 && insub.exam_ref===0" @click="this.playVideo(insub.id,0)" style=" margin-top: 2%;cursor:pointer">
              <va-icon class="material-icons" style="color: var(--va-greencolor);font-size: 30px">play_circle</va-icon>
            </div>
            <div v-else-if="collapse.Buyed===1 && insub.exam_ref>0" @click="this.goToPageNeedLogin('/exam/'+insub.exam_ref)" style=" margin-top: 2%;cursor:pointer">
              <va-icon class="material-icons" style="color: var(--va-greencolor);font-size: 30px">edit_square</va-icon>
            </div>

            <div v-else @click="this.myToast(this.$t('Meets.notPurchased'),2)" style=" margin-top: 2%;">
              <font-awesome-icon icon="fa-solid fa-lock" style="font-size: 26px;color: var(--va-basecolor)"/>
            </div>
          </div>
        </div>
      </va-collapse>
    </va-accordion>

  </div>
  <div  v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px;padding-bottom: 1%">
    <div class="row">
      <p style="padding: 5% 4% 3% 4%;font-weight: bold;width: 50%;margin-top: 1%">{{$t('Meets.userComments')}}</p>
      <div @click="this.open()" style="width: 44%;margin: 1% 3% 0 3%;">
        <p style="font-weight: bold;
          padding: 6px 13px 5px 11px;
          margin-top: 5%;
          background: var(--va-greencolor);
          color: white;
          border-radius: 20px;
          text-align: center;
          height: 32px;" >
          <span  style="padding-bottom: 5px;cursor: pointer">{{$t('Meets.registerComment')}}</span><font-awesome-icon style="margin:1px 5px 0 5px" icon="fa-solid fa-plus" /></p>
      </div>
    </div>
    <div class="row" id="meetcomment">
      <p style="padding: 30px 15px 0 15px;width: 40%;font-size: 13px">{{$t('Meets.filterComments')}}</p>
      <div style="width: 58%;border-radius:10px;height: 45px;margin: 20px 0 0 0;">
        <select v-model="this.comment_filter" @change="this.moreComment()" class="myinput" style="width: 95%">
          <option value="-2">{{$t('Meets.allComments')}}</option>
          <option value="-1">{{$t('Meets.wholeCourse')}}</option>
          <option v-for="(mt, i) in collapses" :key="i" :value="i">{{mt.title}}</option>
        </select>
      </div>
    </div>
    <Loading v-if="this.geted_comment_filter===1"/>
    <p v-if="this.comments.length===0" style="width: 100%;text-align: center;margin: 10% 0 8% 0">{{$t('Meets.noComment')}}</p>

    <div v-for="comment in comments" :key="comment.id" v-if="this.geted===2 && this.geted_comment_filter===0" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px">
      <div class="row" style="padding: 2% 2% 0 2%">
        <div style="width: 10%;">
          <div style="width: 35px;border-radius: 35px;height:35px">
            <font-awesome-icon v-if="comment.profilepic==='nopic'" icon="fa-solid fa-circle-user" style="width: 35px;height: 35px;font-size: 1.9rem"  :style="{ color: '#bebebe' }"/>
            <!--         <img v-if="comment.profilepic==='nopic'" style="width: 45px;height: 45px" class="img-contact" src="../assets/images/walletgood.png">-->
            <img v-else style="width: 40px;height: 40px" class="img-contact" :src="this.baseurl+'/images/profile/'+comment.profilepic">
          </div>
        </div>
        <div style="width: 47%;margin: 12px 3% 0 0">{{comment.name}}</div>
        <div style="width: 38%;margin: 12px 0 0 0">
          <Rating :size="'0.85rem'" :rate="comment.rating" style="margin-left: 4%"/>
        </div>
      </div>
      <div v-if="comment.file_type==='pic'" style="text-align: center">
        <img :src="this.baseurl+'/images/comment/'+comment.file" style="max-height:200px;margin:2% 2% 1% 2%;max-width:96%; border-radius:5px ">
      </div>
      <audio v-else-if="comment.file_type==='audio'" preload="none" webkit-playsinline playsinline controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;height: 100px">
        <source :src="this.baseurl+'/images/comment/'+comment.file"  type="audio/mpeg" />
      </audio>
      <video v-else-if="comment.file_type==='video'" controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;margin-top: 15px">
        <source :src="this.baseurl+'/images/comment/'+comment.file"  type="video/mp4" />
      </video>
      <pre style="width: 100%;padding: 2% 3% 4% 3%;direction: rtl;line-height: 1.4;">{{comment.comment}}</pre>

      <div class="row justify-space-between" >
        <span text-color="white" color="success" style="idth: auto;
    margin: 0px 2% 10px 0px;
    background: var(--va-greencolor);
    border-radius: 6px;
    padding: 3px 10px 3px 10px;
    font-size: 12px;
    color: white;">{{comment.meet_name}}</span>
        <p style="width: 43%;text-align: left;direction: rtl;margin:8px 0 0 2%;color:#a4a4a4;font-size: 13px">{{comment.date}}</p>
      </div>

    </div>
    <button @click="this.moreComment(0)" v-if="this.geted===2 && this.getedMore!==1 && this.getedMore!==2 && this.comments.length>0 && this.geted_comment_filter===0" class="buybtn" type="button">
      <font-awesome-icon style="margin:1px 0 0 5px" icon="fa-solid fa-angle-down" />
      {{$t('Meets.moreComments')}}
    </button>
    <button v-if="this.geted===2&& this.getedMore===1 && this.geted_comment_filter===0" type="button" class="buybtn">
      <div style="width: 100%;text-align: center">
        <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
      </div>
    </button>



  </div>

  <div style="position: relative;width: 100%">
    <Footer :selected_num="3" />
  </div>

  <div id="myModal" class="modal" style="position: absolute !important;max-width: 540px">

    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;">

      <div class="row" style="margin-bottom: 10px">
        <p style="width: 78%;padding:20px 20px 0 20px">{{$t('Meets.registerComment')}}</p>
        <div style="width:14%; margin: 0 4% 0 4%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
          <va-avatar style="margin: 10px 10px 0 10px;cursor: pointer" size="small"  @click="this.close()"   color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        </div>
      </div>
      <hr/>
      <div style="width:96%;margin: 10px 2% 5px 2%;padding:10px 10px 0 10px ;cursor: pointer;border-radius: 15px;">
        <div class="row" style="margin-bottom: 30px">
          <p style="width: 50%;margin-top: 1%">{{$t('Meets.pointsCourse')}}:</p>
          <va-rating color="#ffdd02"  v-model="this.com_rating" style="width: 50%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}"/>
        </div>
        <div class="row" style="margin-bottom: 30px;margin-top: 30px">
          <p style="width: 30%;margin-top: 13px">{{$t('Meets.part')}}:</p>
          <select v-model="this.meet_ref" style="width: 68%;margin-left: 2%;" class="name">
            <option value="0" selected="selected">{{$t('Meets.wholeCourse')}}</option>
            <option v-for="item in collapses" :value="item.id">{{ item.title }}</option>
          </select>
        </div>
        <div class="row" style="margin: 20px 0 20px 0">
          <input v-model="this.show_name" type="checkbox" class="va-checkbox__square" id="shname">
          <label for="shname" style="margin: 1px 5px 0 10px">{{$t('Meets.displayInformation')}}</label>
        </div>
        <div class="row" >
          <p style="width: 70%;padding: 10px 0 0 0">
            {{$t('Meets.attach')}}:
            <br/>
            <span style="font-size: 11px;color: #8d8c8c"></span>
          </p>
          <label for="file-upload"  class="custom-file-upload" style="width: 30%;height:35px;background-color: #6C9FD8;color: white;text-align: center;border-radius: 25px;padding: 8px 0 8px 0;cursor: pointer">
            {{$t('Meets.selectFile')}}
          </label>
          <input id="file-upload" type="file" @change="getFileName()"/>
        </div>
        <p style="font-size: 12px;color: #8d8c8c;margin: 5px 5px 0 0">{{$t('Meets.allowFormat')}}: mp3,mp4,jpg,png</p>
        <pre v-if="this.filename!==''" style="color: #8d8c8c;padding: 5px 0 0 5px">{{this.filename}}</pre>

        <div class="row" style="margin:30px 0 5px 0">
          <p style="width: 100%">{{$t('Meets.opinion')}}:</p>
        </div>
        <div class="row" style="margin-bottom:5%">
          <textarea v-model="this.com_comment" type="tel" style="height:60px;width: 96%;padding: 10px" class="comment"></textarea>
        </div>
        <p v-if="this.geted_upload===1" style="font-size: 12px;margin-bottom: 1px">{{$t('Meets.uploading')}}</p>
        <va-progress-bar v-if="this.geted_upload===1" indeterminate color="var(--va-basecolor)"/>
        <button v-if="this.getedCom===1" class="comment_btn" type="button" style="margin:4px 0 3% 0;text-align: center;">
          <div style="width: 100%;text-align: center">
            <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
          </div>
        </button>
        <button v-else @click="this.sendComment()" class="comment_btn" type="button" style="margin: 4px 0 3% 0;text-align: center;">
          {{$t('Meets.registerComment')}}
        </button>
      </div>
    </div>

  </div>
  <div id="mySpeed" class="modal" style="position: absolute !important;max-width: 540px">

    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;">

      <div class="row" style="margin-bottom: 5%">
        <p style="width: 91%;padding:5% 5% 0 0">{{$t('Meets.playbackSpeed')}}</p>
        <va-avatar style="margin-top: 3%;cursor: pointer" size="small"  @click="this.close_speed()" class="mr-4" color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        <h2>&nbsp;</h2>
      </div>
      <hr style="margin: 0 4% 0 4%" />
      <p @click="this.play_speed=0.75" :class="{ active_speed: this.play_speed === 0.75 }" style="text-align: center;padding: 3%">0.75</p>
      <hr style="margin: 0 4% 0 4%" />
      <p @click="this.play_speed=1" :class="{ active_speed: this.play_speed === 1.0 }" style="text-align: center;padding: 3%">1.0</p>
      <hr style="margin: 0 4% 0 4%" />
      <p @click="this.play_speed=1.25" :class="{ active_speed: this.play_speed === 1.25 }" style="text-align: center;padding: 3%">1.25</p>
      <hr style="margin: 0 4% 0 4%" />
      <p @click="this.play_speed=1.5" :class="{ active_speed: this.play_speed === 1.5 }" style="text-align: center;padding: 3%">1.5</p>
      <hr style="margin: 0 4% 0 4%" />
      <p @click="this.play_speed=1.75" :class="{ active_speed: this.play_speed === 1.75 }" style="text-align: center;padding: 3%">1.75</p>
      <hr style="margin: 0 4% 0 4%" />
      <p @click="this.play_speed=2.0" :class="{ active_speed: this.play_speed === 2.0 }" style="text-align: center;padding: 3%;margin-bottom: 2%">2.0</p>
      <button @click="this.change_speed();this.close_speed()" class="comment_btn" type="button" style="margin: 1% 2% 3% 2%;text-align: center;width: 96%;">
        {{$t('Meets.changeSpeed')}}
      </button>
    </div>

  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import Rating from '../components/Rating.vue'
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark as faBookmarked,faRotateLeft,faRotateRight,faGaugeSimpleHigh,faCar} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock,faBookmark,faCirclePlay,faCirclePause } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
// import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import {useToast} from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'

library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark,faBookmarked,faRotateLeft,faRotateRight,faCirclePlay,faCirclePause,faGaugeSimpleHigh,faCar)
export default {
  name: "Meets",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,Swiper, SwiperSlide,Rating,GDialog
  },
  mounted() {
    this.isInStandaloneMode();
    this.getRow();
    // window.scrollTo(0,0);
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
    localStorage.setItem('course_ref',this.$route.params.id.toString());

    if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
      this.isLogin=false;
    }
    else{
      this.isLogin=true;
    }
    // window.addEventListener('contextmenu', function (e) {
    //   e.preventDefault();
    // }, false);
  },
  methods:{
    viewInfo(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 5, // Wait for 5 seconds
            data: {
              action:'viewInfo',
              course_ref:this.$route.params.id.toString(),
              product_ref:this.product_ref.toString(),
              last_sec:this.videoData.currentTime.toString(),
              last_speed:this.play_speed.toString(),
              total_duration:this.videoData.element.duration.toString(),
              elapsed:this.elapsed.toString(),
            },
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){}
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
          })
          .catch(error => {});
    },
    initializeVideo(type) {
      if(type==='audio'){
        this.videoData.element = document.getElementById('myAudio');
      }
      else{
        this.videoData.element = document.getElementById('myVideo');
      }
      if(this.view_last_sec>0){
        this.videoData.element.currentTime=this.view_last_sec
        this.videoData.element.pause()
        this.view_last_sec=0;
      }
      this.videoData.element.addEventListener('play', this.startMonitoring);
      this.videoData.element.addEventListener('pause', this.stopMonitoring);
      this.videoData.element.addEventListener('ended', this.handleVideoEnded);
    },
    handleVideoEnded() {
      this.playVideo(this.product_ref,1);
    },
    startMonitoring() {
      this.videoData.intervalId = setInterval(this.printElapsedTime, this.elapsed*1000);
      this.videoData.isPlaying = true;
    },
    stopMonitoring() {
      clearInterval(this.videoData.intervalId);
      this.videoData.isPlaying = false;
    },
    printElapsedTime() {
      this.videoData.currentTime = this.videoData.element.currentTime;
      this.viewInfo();
    },
    openTel(tel){
      document.location.href="tel:"+tel;
    },
    getFileName(){
      this.filename= document.getElementById("file-upload").value;
    },
    moreComment(){
      this.getedMore=1;
      if(this.comment_filter!==0){
        this.geted_comment_filter=1;
      }
      const mydata = {
        action:'moreComment',
        CourseRef:this.$route.params.id,
        comment_filter:this.comment_filter.toString(),
        lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 30, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            this.geted_comment_filter=0;
            if(response.data.ok===1){
              this.getedMore=2;
              if(response.data.comments!==null){
                this.comments=response.data.comments;
              }
              else{
                this.comments=[];
              }

            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedMore=3;
              this.$swal({
                title: this.$t('General.error'),
                text: response.data.msg,
                icon: 'error',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            this.getedMore = 3;
            this.geted_comment_filter = 0;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });
    },
    sendComment(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      var err='';
      if(err!==''){
        this.$swal({
          title: this.$t('General.error'),
          text: err,
          icon: 'error',
          confirmButtonText:this.$t('General.ok'),
          customClass: {
            confirmButton: 'btn btn-primary'
          },
          buttonsStyling: false
        });
        return;
      }
      this.getedCom=1;
      const mydata = {
        action:'sendComment',
        CourseRef:this.$route.params.id,
        comment:this.com_comment,
        title:this.title,
        subject:this.subject,
        rating:this.com_rating.toString(),
        meet_ref:this.meet_ref.toString(),
        show_name:this.show_name===true?1:0,
        lang:this.$i18n.locale,
      };
      const file = document.querySelector('#file-upload');
      if(file.files.length!==0){
        this.geted_upload=1;
        mydata.file=file.files[0]
      }
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 120, // Wait for 5 seconds
            data: mydata,
            headers: {
              'Content-Type': 'multipart/form-data',
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            this.geted_upload=0;

            document.getElementById("file-upload").value='';
            this.filename='';

            if(response.data.ok===1){
              this.getedCom=2;
              this.close();
              this.com_comment="";
              this.title="";
              this.subject="";
              this.$swal({
                title: this.$t('Meets.commentSent'),
                text: this.$t('Meets.afterConfirmation'),
                icon: 'success',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedCom=3;
              this.$swal({
                title: this.$t('General.error'),
                text: response.data.msg,
                icon: 'error',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            this.geted_upload=0;
            this.getedCom = 3;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });

    },
    goToInvoice(type='',meetref=0){
      console.log(meetref);
      localStorage.setItem('typeGl', type);
      localStorage.setItem('subRefGl', '0');
      localStorage.setItem('subRef', '0');
      localStorage.setItem('CourseRefGl', this.$route.params.id.toString());
      localStorage.setItem('MeetRefGl', meetref.toString());
      localStorage.setItem('Page', "meets");
      localStorage.setItem('amount', this.amount.toString());
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        // this.loginDialog=true;
        this.$router.push({ path: '/mobile'})
      }
      else {
        this.$router.push({ path: '/invoice'})
      }

    },
    goToPage(page){
      this.$router.push({ path: page})
    },
    goToPageNeedLogin(page){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      else{
        this.$router.push({ path: page})
      }

    },

    openFile(id,isdl){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      // else if(!this.iswebapp){
      //   this.myToast("دانلود فایل ها فقط در گوشی امکان پذیر است",3)
      //   return;
      // }
      this.getedLink=1;
      const mydata = {
        action:'getLink',
        ProductRef:id,
        lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 30, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              // this.option.url=response.data.url;
              if(response.data.type==='pdf'){
                if(isdl===1){
                  window.location.replace(response.data.url)
                }
                else{
                  this.$router.push({ path: '/article/'+response.data.filename });
                  return;
                }
              }
              else{
                if(isdl===1){
                  window.location.href = response.data.url;
                }
                else{
                  window.open(response.data.url,"_self");
                }
              }
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedLink=3;
              this.$swal({
                title: this.$t('General.error'),
                text: response.data.msg,
                icon: 'error',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            this.getedLink = 3;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });
    },
    playVideo(id,is_next){
      this.product_ref=id;
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      // else if(!this.iswebapp){
      //   this.myToast("پخش فایل ها فقط در گوشی امکان پذیر است",3)
      //   return;
      // }
      this.getedLink=1;
      const mydata = {
        action:'getLink',
        ProductRef:id,
        lang:this.$i18n.locale,
        is_next:is_next,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 30, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              // this.option.url=response.data.url;
              this.play_url=response.data.url;
              this.play_speed=1.0;
              if(response.data.type==='audio'){
                // this.style.height='120px';
                this.file_type='audio';
              }
              else if(response.data.type==='video'){
                this.file_type='video';
              }
              this.getedLink=2;
              this.product_ref=response.data.product_ref
              this.meet_ref_link=response.data.meet_ref
              this.product_name=response.data.product_name
              window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
              });
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else if(response.data.ok===5){
              this.getedLink=0;
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedLink=3;
              this.$swal({
                title: this.$t('General.error'),
                html: `${response.data.msg}`,
                icon: 'error',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            this.getedLink = 3;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });
    },
    myToast(alert,type){
      if(type===1){
        useToast().success(alert, {
          timeout: 2000,
          position:'top-center',
          rtl: this.$t('config.dir')==='rtl'?true:false
        });
      }
      else if(type===2){
        useToast().warning(alert, {
          timeout: 2000,
          position:'top-center',
          rtl: this.$t('config.dir')==='rtl'?true:false
        });
      }
      else if(type===3){
        useToast().error(alert, {
          timeout: 2000,
          position:'top-center',
          rtl: this.$t('config.dir')==='rtl'?true:false
        });
      }

    },
    setFav(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      if(this.changeFav===1){
        this.changeFav=0;
        this.myToast('دوره '+this.courseName+' از علاقه مندی ها حذف شد',1);
      }
      else{
        this.changeFav=1;
        this.myToast('دوره '+this.courseName+' به علاقه مندی ها اضافه شد',1);
      }

      const mydata = {
        action:'setFav',
        setFav:this.changeFav.toString(),
        CourseRef:this.$route.params.id,
        lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 30, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){}
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
          })
          .catch(error => {});

    },
    getRow(){

      this.geted=1;
      const mydata = {
        action:'meets',
        CourseRef:this.$route.params.id,
        lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 30, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {

            if(response.data.ok===1){

              this.collapses=response.data.data;
              this.courseName=response.data.courseName;
              this.courseTime=response.data.courseTime;
              this.courseSection=response.data.courseSection;
              this.courseParticipants=response.data.courseParticipants;
              this.courseTeacher=response.data.courseTeacher;
              this.coursePoint=response.data.coursePoint;
              this.courseShortComment=response.data.courseShortComment;
              this.courseComment=response.data.courseComment;
              this.courseCoverPic=response.data.courseCoverPic;
              this.courseCoverType=response.data.courseCoverType;
              this.courseType=response.data.courseType;
              this.PriceOff=response.data.PriceOff;
              this.PriceOffInt=response.data.PriceOffInt;
              this.needSubscription=response.data.needSubscription;
              this.buyed=response.data.buyed;
              this.can_buy=response.data.can_buy;
              this.com_rating=response.data.com_rating;
              this.com_comment=response.data.com_comment;

              this.comments=response.data.comments;
              this.changeFav=response.data.isfav;
              this.course_type=response.data.course_type;
              this.elapsed=response.data.elapsed;
              if(response.data.has_view_info===1){
                this.product_ref=response.data.view_product_ref;
                this.view_last_sec=response.data.last_sec;
                setTimeout(() => {
                  this.playVideo(this.product_ref,0);
                }, 500);
              }

              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.geted=3;
              this.$swal({
                title: this.$t('General.error'),
                text: response.data.msg,
                icon: 'error',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            this.geted = 3;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });

    },
    slider_click(v){
      console.log(v)
    },
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },

    close_speed(){
      var modal = document.getElementById("mySpeed");
      modal.style.display = "none";
    },
    open_speed(){
      var modal = document.getElementById("mySpeed");
      modal.style.display = "block";
    },
    close(){
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    },
    open(){
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
    },
    playPause(){
      var mainVideo = document.querySelector("video");
      if(this.file_type==='audio'){
        mainVideo = document.querySelector("audio");
      }

      if(mainVideo.paused){
        mainVideo.play();
        this.playIcon="fa-regular fa-circle-pause"
      }
      else{
        mainVideo.pause();
        this.playIcon="fa-regular fa-circle-play"
      }
    },
    jump(t){
      var mainVideo = document.querySelector("video");
      if(t==='+'){
        if(this.file_type==='audio'){
          mainVideo = document.querySelector("audio");
        }
        mainVideo.currentTime += 15
      }
      else{
        if(this.file_type==='audio'){
          mainVideo = document.querySelector("audio");
        }
        mainVideo.currentTime -= 15
      }
    },
    change_speed(){
      var mainVideo = document.querySelector("video");
      if(this.file_type==='audio'){
        mainVideo = document.querySelector("audio");
      }
      mainVideo.playbackRate=this.play_speed;
    },
    isInStandaloneMode(){
      if((window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone) || document.referrer.includes('android-app://')){
        this.iswebapp=true;
        return true;
      }
      else{
        this.iswebapp=false;
        return false;
      }
    },
  },
  setup() {
    return {
      modules: [Autoplay,Navigation, Pagination, Scrollbar, A11y],
    };
  },

  data(){
    return{
      color:"#FFFFFF",
      meet_ref_link:0,
      view_last_sec:0,
      product_ref:0,
      elapsed:10,
      videoData: {
        element: null,
        currentTime: 0,
        isPlaying: false,
        intervalId: null,
      },
      geted:0,
      getedCom:0,
      getedMore:0,
      getedLink:0,
      geted_comment_filter:0,
      loginDialog:false,
      rating:3,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      type:1,
      courseName:"",
      courseTime:"",
      courseSection:"",
      courseParticipants:"",
      courseTeacher:"",
      coursePoint:"",
      courseShortComment:"",
      courseComment:"",
      courseCoverPic:"",
      courseCoverType:"pic",
      courseType:"",
      PriceOff:"",
      PriceOffInt:"",
      needSubscription:0,
      buyed:0,
      can_buy:1,
      amount:1,
      url:"",
      test:"",
      comments:[],
      changeFav:0,

      value: [true, false, false],
      collapses: [],
      is_short:1,

      com_rating:5,
      com_comment:"",

      play_url:"",
      playIcon:"fa-regular fa-circle-play",
      is_driving:0,
      play_speed:1.0,
      file_type:'video',
      iswebapp:false,
      course_type:0,
      meet_ref:0,
      filename:"",
      geted_upload:0,
      comment_filter:-2,
      show_name:true,
      title:"",
      subject:"",
      /// player
      option: {
        url: "",
        title: this.appname_en,
        poster: '/assets/sample/poster.jpg',
        volume: 0.5,
        isLive: false,
        muted: false,
        autoplay: true,
        pip: false,
        autoSize: false,
        autoMini: false,
        screenshot: false,
        setting: true,
        loop: true,
        flip: false ,
        playbackRate: true,
        aspectRatio: true,
        fullscreen: true,
        fullscreenWeb: true,
        subtitleOffset: false,
        miniProgressBar: true,
        mutex: true,
        backdrop: false,
        playsInline: true,
        autoPlayback: true,
        airplay: true,
        theme: this.basecolor,
        lang: navigator.language.toLowerCase(),
        whitelist: ['*'],
        moreVideoAttr: {
          crossOrigin: 'anonymous',
        },
        settings: [

        ],
      },
      style: {
        width: "100%",
        height: "400px",
        margin: "0",
        borderRadius:"10px 10px 0 0 !important"
      },
      isLogin:false,
      product_name:""
    }
  }
};

</script>
<style>
.active_play{
  border-right: 5px solid red;
  border-radius: 5px;
}
#outer {
  width: 100%;
  height: 300px;
  -moz-border-radius-topleft: 20px;
  -moz-border-radius-topright: 20px;
  overflow: hidden;
  position: relative;
}
.video {
  position: relative;
  left: 0;
  width: 100% !important;
  top: 0;
  opacity: 1;
}

.buybtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.va-collapse__header__text{
  padding-right: 3%;
  font-size: 14px;
}
.overlay {
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  position: fixed;
  background: rgba(119, 119, 119, 0.6);
}

.overlay__inner {
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  position: absolute;
}
.overlay__content {
  left: 50%;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
}

.spinner {
  width: 75px;
  height: 75px;
  display: inline-block;
  border-width: 4px;
  border-color: rgba(255, 255, 255, 0.15);
  border-top-color: #fff;
  animation: spin 1s infinite linear;
  border-radius: 100%;
  border-style: solid;
}
@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
.buyallbtn{
  width: 100%;
  text-align: center;
  margin:4% 8% 0 8%;
  height: 45px;
  background-color: var(--va-seccolor);
  color:white;
  border-radius: 10px;
  border:unset
}
.buymeetbtn{
  width: 96%;
  text-align: center;
  margin:0 2% 0 2%;
  height: 45px;
  color:var(--va-greencolor);
  border-radius: 10px;
  border:1px solid var(--va-greencolor);
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  -webkit-animation-name: fadeIn; /* Fade in the background */
  -webkit-animation-duration: 0.4s;
  animation-name: fadeIn;
  animation-duration: 0.4s
}
/* Modal Content */
.modal-content {
  position: fixed;
  bottom: 0;
  background-color: #fefefe;
  width: 100%;
  -webkit-animation-name: slideIn;
  -webkit-animation-duration: 0.4s;
  animation-name: slideIn;
  animation-duration: 0.4s
}
/* The Close Button */
.close {
  color: black;
  float: left;
  font-size: 28px;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
/* Add Animation */
@-webkit-keyframes slideIn {
  from {bottom: -300px; opacity: 0}
  to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
  from {bottom: -300px; opacity: 0}
  to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
  from {opacity: 0}
  to {opacity: 1}
}

@keyframes fadeIn {
  from {opacity: 0}
  to {opacity: 1}
}
.name{
  width: 100%;height: 35px;
  text-align: right;
  direction: rtl;
  outline: none !important;
  border-bottom:1px solid #8a8a8a;
  border-top-width:0px;
  border-right-width:0px;
  border-left-width:0px;
  padding-left: 10px;
}
.comment{
  width: 100%;height: 35px;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 10px;
  padding: 10px;
}
.minput{
  width: 100%;height: 25px;
  text-align: right;
  direction: rtl;
  outline: none !important;
  border-bottom:1px solid #8a8a8a;
  border-left: unset;
  border-right: unset;
  border-top: unset;
  padding-left: 10px;
}
.comment_btn{
  width: 100%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.active_speed{
  color: var(--va-basecolor);
  font-weight: bold;
  font-size: 20px;
}
option {
  font-family: IRANYekan;
}
input[type="file"] {
  display: none;
}
.myinput{
  padding: 0 8px 0 10px;
  background: #eeeeee;
  border-radius: 25px;
  height: 35px;
  border: 0;
  font-family: IRANYekan;
}
html {
  scroll-behavior: smooth;
}
.buybtncounter{
  width: 40%;
  text-align: center;
  margin-top: 3px;
  padding: 0 20px 0 20px;
  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.compbtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color:#95E292FC;
  color:white;
  border-radius: 10px;
  border:unset;
}
</style>