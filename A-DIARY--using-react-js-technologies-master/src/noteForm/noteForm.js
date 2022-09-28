import React,{ Component } from 'react';
import './noteForm.css';

class NoteForm extends Component {
    constructor (props){
        super(props);
        this.state = {
            newNoteContent : '',
        };
        this.handleUserInput = this.handleUserInput.bind(this);
        this.writeNote = this.writeNote.bind(this);
    }

    // when the user input changes set the newNoteContent 
    // to the value of what's in the input box

    handleUserInput(e) {
        // console.log(this);
        
        this.setState({
            newNoteContent : e.target.value, // the value of the text input
        })
    }

    writeNote(){
        // call a method that sets the noteContent for a note to the value of the input
        // set newNoteContent back to an empty string.

        this.props.addNote(this.state.newNoteContent)
        this.setState({
            newNoteContent : '',
        })
    }

    render(){
        return(
            <div className="formWrapper">
                <input className = "noteInput"
                placeholder ="Write a new note ..."
                value="{ this.state.newNoteContent }"
                onchange = "{ this.handleUserInput }"/>
                <button className="noteButton" onClick={this.writeNote}>Add Note</button>
            </div>
        )
    }
}

export default NoteForm;