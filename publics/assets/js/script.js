'use strict';

const toggle = document.getElementById('toggle');
let isHidden = false;
toggle.addEventListener('click',function(){
      const menu = document.querySelector('.menu');
      if(!isHidden){
            menu.classList.add('show');
      }else{
            menu.classList.remove('show');
      }
      isHidden = !isHidden;
})
      

      // $.ajax({
      //       type: 'get',
      //       url: 'http://localhost/challenge/index.php?action=getUser',
      //       data:{},
      //       success: function(dataPhp){
      //             console.log(JSON.parse(dataPhp));
      //       }
      // })
//const xmlrequest = new XMLHttpRequest()
$(document).ready(function(){
      //alert('fdfsfs')
      
      function loadConversation(motCle=""){
            $.ajax({
                  type: 'post',
                  url: `http://localhost/challenge/index.php?action=getConversation&motCle=${motCle}`,
                  data:{},
                  success: function(result){
                        result = JSON.parse(result);
                        const conversationContainer = document.querySelector('.conversation-container');
                       // console.log(result)
                        conversationContainer.innerHTML=""
                        // console.log(result)
                        if(result.haveConversation){
                       
                              for(let c of result.conversations){
                                    //creation d'une balise div
                                   console.log(c);
                                    const conversation = document.createElement('div');
                                    //ajout de classe a la balise div
                                    conversation.classList.add('conversation');
                                    //ajout attribut id
                                    conversation.setAttribute('id',c.idConversation);
                                    //ajout de contenu a l element div 
                                    conversation.innerHTML = `
                                    <h3 class="conversation-header">${c.interlocuteur.name}</h3>
                                    <p class="consersation-content">${c.titre}</p>
                                    `;
                                    conversationContainer.append(conversation);
                                    $(`#${c.idConversation}`).on('click',function(){
                                          alert('ok')
                                          //chargement de msg 
                                          loadMessage(c.idConversation,c.idInterlocuteur);   
                                    })
                                 
                              }
                        }

                  }
            })
      }
      function loadMessage(idConversation,idInterlocuteur){
            $.ajax({
                  type:'post',
                  url:`http://localhost/challenge/index.php?action=getMessages&id=${idConversation}`,
                  success: function(dataMessages){ 
                        const conversationMessages =JSON.parse(dataMessages);
                        console.log(conversationMessages)
                        //selection de l elemnt .conversion-detail-container
                        const conversationDetailContainer = document.querySelector('.conversion-detail-container');
                        conversationDetailContainer.innerHTML="";
                        for(let message of conversationMessages){
                              // console.log("1 inter"+idInterlocuteur)
                              // console.log("1 sender"+message.idSender)
                              const div = document.createElement('div');
                              if(idInterlocuteur==message.idSender){
                                    div.classList.add('message-inter-contenaire');
                                    div.innerHTML =`
                                    <p class="message message-interlocuteur">
                                    ${message.content}
                                    </p>`
                              }    
                              else{
                                    div.classList.add('message-user-container');
                                    div.innerHTML =`
                                    <p class="message message-user">
                                    ${message.content}
                                    </p>
                                     `
                              }
                              conversationDetailContainer.append(div)
                              const btnSend = document.getElementById('send');
                              btnSend.setAttribute('data-idConversation',idConversation)
                              btnSend.setAttribute('data-idInterlocuteur',idInterlocuteur)

                              // alert("ok")
                        }
                        
                  }
            })  
      }
      //affichage main pannel
      function showMainPanel(){
            $(".main-pannel").css('display','block');
            $('header').css('display','none');
           // alert('main pannel')
      }
      //masque main pannel
      function hideMainPanel(){
            $(".main-pannel").css('display','none');
            $('header').css('display','block');
      }
      //chargement de page
      //verification si user est deja connecte
      $.ajax({
            type:'get',
            url:'http://localhost/challenge/index.php?action=isConnected',
            data:{},
            success: function(dataConnection){
                  dataConnection = JSON.parse(dataConnection);
                  console.log(dataConnection);
                  //on teste si deja connecte et on affiche le main panel
                  if(dataConnection.isConnected){
                        showMainPanel()
                        loadConversation();
                  }else{

                  }
            }
      })
      //Connection
      $("#connexion").on('click',function(){
            const email = $('#email').val();
            const pwd =$('#pwd').val();
            $.ajax({
                  type: 'post',
                  url: 'http://localhost/challenge/index.php?action=authentification',
                  data:{'email': email, 'pwd': pwd},
                  success: function(dataPhp){
                       console.log(dataPhp);
                       dataPhp = JSON.parse(dataPhp);
                       console.log(dataPhp.error);
                       if(!dataPhp.error){
                           showMainPanel();
                         //  alert('sdqsdqd')
                           // Recuperation des conversations de l'utilisateur connecté
                           loadConversation();
                        }
                  }
            })
      });

      //
      // $('.conversation').on('click',function(){
      //       $.ajax({
      //             type:'post',
      //             url: 'http://localhost/challenge/index.php?action=messages',
      //             data: {
      //                   idSender: 1,
      //                   idReceiver: 2
      //             },
      //             success: function(messages){
      //                  for (let message of JSON.parse(messages)){
      //                         console.log(message.content+'++++++++++++')
      //                  }
      //             }
      //       })
      // })
      $('#send').on('click',function(e){
            e.preventDefault();
            const btnSend = document.getElementById('send');
            $.ajax({
                  type:'post',
                  url:'http://localhost/challenge/index.php?action=sendmsg',
                  data:{
                        content: $('#msg').val(),
                        idConversation:btnSend.getAttribute('data-idConversation'),
                        idInterlocuteur:btnSend.getAttribute('data-idInterlocuteur')
                  },
                  success: function (data){
                        const msgContainer = document.querySelector('.conversion-detail-container');
                        const msg = document.createElement('div');
                        msg.classList.add('message-user-container');
                       msg.innerHTML =`
                        <p class="message message-user">
                              ${$('#msg').val()}
                        </p>
                       `
                       msgContainer.append(msg);
                  }
            })
      })

      $('#envoyer').on('click',function(){
         
            nouvelleConversation();
      })
      function nouvelleConversation(){
          const email = document.getElementById('emailReceiver')
          const titre = document.getElementById('titreConversation')
          const content = document.getElementById('content')
          $.ajax({
                  type:'post',
                  url:'http://localhost/challenge/index.php?action=newConversation',
                  data:{
                        email: email.value,
                        titre: titre.value,
                        content: content.value
                  },
                  success: function(data){
                        loadConversation();
                  }
          })
      }

      //Deconnection
      //  1- ajax requete de deconnection  (action = logout)
      //  2- traiteme de la requete (suppression de l'user dans la session) 
      function deconnection(){
            
            
                  $.ajax({
                        type: 'get',
                        url:'http://localhost/challenge/index.php?action=logout',
                        data:{},
                        success: function(data){
                              hideMainPanel();
                        }
                  })
          
      }
      $(".btn-logout").on('click',function(){
             deconnection();
      })

      //sign in
      //1 recuperer les infos dans la formulaire
      //2 envoyer les infos vers l'api (back end)
      function singIn(){
            const nomUser = $('#sNom').val();
            const emailUser =$('#sEmail').val();
            const mdpUser=$('#sMdp').val();
            const confMdp =$('#sConfMdp').val();
            //validation formulaire
            if(mdpUser===confMdp){
                  $.ajax({
                        type:'post',
                        url:'http://localhost/challenge/index.php?action=signIn',
                        data:{
                             name: nomUser,
                             email:emailUser,
                             pwd:mdpUser,
                             img:'1'
                        },
                        success: function(data){
                              showMainPanel();
                              console.log(data)
                             // loadConversation();
                        }
                  })
            }
      }
      $('#inscription').on('click',function(){
            singIn();
      })
      //Recherche conversation
      document.querySelector('.search').addEventListener('keyup',function(){
            loadConversation(this.value);
      })

      

})