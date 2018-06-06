import React, { Component } from 'react';
import baseUrl from '../../helpers/baseUrl';
import TinyMCE from 'react-tinymce';
import Dropzone from 'react-dropzone';
import axios from 'axios';

/*        handleDrop = files => {
              // Push all the axios request promise into a single array
              const uploaders = files.map(file => {
                // Initial FormData
                const formData = new FormData();
                formData.append("file", file);
                formData.append("tags", `codeinfuse, medium, gist`);
                formData.append("upload_preset", "pvhilzh7"); // Replace the preset name with your own
                formData.append("api_key", "1234567"); // Replace API key with your own Cloudinary key
                formData.append("timestamp", (Date.now() / 1000) | 0);
                
                // Make an AJAX upload request using Axios (replace Cloudinary URL below with your own)
                return axios.post("https://api.cloudinary.com/v1_1/codeinfuse/image/upload", formData, {
                  headers: { "X-Requested-With": "XMLHttpRequest" },
                }).then(response => {
                  const data = response.data;
                  const fileURL = data.secure_url // You should store this URL for future references in your app
                  console.log(data);
                })
              });

              // Once all the files are uploaded 
              axios.all(uploaders).then(() => {
                // ... perform after upload is successful operation
              });
            }*/
      

export default class Index extends Component {

      constructor(props){
            super(props);
            this.state = {
                            title: '', 
                            content: '' ,
                            accept: '',
                            files: [],
                            dropzoneActive: false };           
            this.changeTitle = this.changeTitle.bind(this);
            this.changeContent = this.changeContent.bind(this);            
            this.handleSubmit = this.handleSubmit.bind(this);             
        }                         
              
        componentWillMount() {
                this.baseUrl = baseUrl(this.props)
            } 


        changeTitle(e){
            this.setState({
            title: e.target.value
            })
        }
        changeContent(e){
            this.setState({
            content: e.target.getContent()
            })          
            console.log(e.target.getContent());
        }

        handleSubmit(e){
            e.preventDefault(); 
            const articles = {
            title: this.state.title,
            content: this.state.content,
            image: this.state.files
            }
            let uri = this.baseUrl+"/articles";
            axios.post(uri, articles).then((response) => {
              //window.location.reload()
            });
        }

        onDragEnter() {
            this.setState({
              dropzoneActive: true
            });
          }

          onDragLeave() {
            this.setState({
              dropzoneActive: false
            });
          }

          onDrop(files) {
            this.setState({
              files,
              dropzoneActive: false
            });
          }

          applyMimeTypes(event) {
            this.setState({
              accept: event.target.value
            });
          }

        render() {

            const { accept, files, dropzoneActive } = this.state;
            const overlayStyle = {
              position: 'absolute',
              top: 0,
              right: 0,
              bottom: 0,
              left: 0,
              padding: '2.5em 0',
              background: 'rgba(0,0,0,0.5)',
              textAlign: 'center',
              color: '#fff'
            };

                return (
                    <div>
                        <div className="panel panel-default">
                            <div className="panel-heading">Post Your Feeds</div>
                            <div className="panel-body">
                              <form>
                            <div className="row">
                                 <div className="col-md-12">
                                   <div className="form-group">
                                       <Dropzone
                                            multiple                                                                                      
                                            style={{position: "relative"}}
                                            accept="image/jpeg, image/png"
                                            onDrop={this.onDrop.bind(this)}
                                            onDragEnter={this.onDragEnter.bind(this)}
                                            onDragLeave={this.onDragLeave.bind(this)}
                                          >
                                            { dropzoneActive && <div style={overlayStyle}>Drop files...</div> }
                                            <div>
                                           

                                              <h2>Dropped files</h2>
                                              <ul>
                                                {
                                                  files.map(f => <li>{f.name} - {f.size} bytes</li>)
                                                }
                                              </ul>

                                            </div>
                                          </Dropzone>
                                   </div>
                                 </div>  
                                <div className="col-md-12">
                                <div className="form-group">
                                    <label>Title :</label>
                                    <input type="text" className="form-control"  onChange={this.changeTitle}/>
                                </div>
                                </div>
                                </div>
                                    <div className="row">
                                    <div className="col-md-12">
                                       <div className="form-group"> 
                                        <TinyMCE    
                                        content=""                                        
                                        onChange={this.changeContent}
                                         />
                                       </div>
                                    </div>
                                    </div><br />
                                    <div className="form-group">
                                    <button className="btn btn-primary" onClick={this.handleSubmit}>Post</button>
                                    </div>
                                </form>                              

                            </div>
                        </div>
                    </div>
              
                );
            }
        }