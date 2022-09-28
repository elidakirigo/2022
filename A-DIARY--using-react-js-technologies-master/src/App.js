import React, { Component } from 'react';
import Note from './note/note';
import { DB_CONFIG } from './config/config';
import firebase from 'firebase/app';
import NoteForm from './noteForm/noteForm';
import 'firebase/database';
import './App.css';

class App extends Component {

  constructor(props){

    super(props);

    this.addNote = this.addNote.bind(this);

    this.removeNote = this.removeNote.bind(this);
    
    // we're going to setup the React of our component

    this.app = firebase.initializeApp(DB_CONFIG);

    this.db = this.app.database().ref().child('notes');

    this.state = {
      notes: [ /* { id: 1, noteContent: "Note 1 here!"},{ id: 2, noteContent: "Note 2 here!"} */],
    }
  }
    
    componentWillMount(){
      const previousNotes = this.state.notes;

      // DataSnapShot
      this.database.on('child_added' , snap => {
        previousNotes.push({
          id: snap.key,
          noteContent : snap.val().noteContent,
        })

        this.setState({
          notes: previousNotes
        })
      })

      this.database.on('child_removed', snap => {
        for (let i = 0; i < previousNotes.length; i++) {
          if(previousNotes[i].id === snap.key){
            previousNotes.splice(i , 1);
          }
        }

        this.setState({
          notes: previousNotes
        })
      })
    }

    addNote(note){

      this.database.push().set({ noteContent : note })
      // push the note onto the notes array
    //   const previousNotes = this.state.notes;
    //   previousNotes.push({ id:previousNotes.length + 1, noteContent : note }
    //  );
      
    //   this.setState({
    //     notes : previousNotes,

    //   })
    }

    removeNote(noteId){
      this.database.child(noteId).remove();
    }

  render() {
    return ( 
    <div className="notesWrapper"> 
      <div className="notesHeader">
        <div className="heading">React & firebase to-do List</div>
      </div>
      <div className="notesBody">
        {
          this.state.notes.map( (note) => {
            return (
              <Note 
                noteContent={note.noteContent} 
                noteid={note.id} 
                key={note.id} 
                removeNote = {this.removeNote} />
            )
          })
        }
      </div>
      <div className="notesFooter">
        <NoteForm addNote={ this.addNote }/>
      </div>
    </div>
  );
  }
}

export default App;
