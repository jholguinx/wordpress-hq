import React , { PureComponent } from 'react';
import Autosuggest from 'react-autosuggest';

class SuggestionInput extends PureComponent{
    constructor(props){
        super(props);
        this.state = {
            inputProps: {
                placeholder: '',
                value: '',
                onChange: this.onChange.bind(this),
                name: '',
                id:''
            },
        };
    }
    componentDidMount() {
        this.setState({
            inputProps: {
                ...this.state.inputProps,
                placeholder: this.props.placeholder,
                name: this.props.name,
                id: this.props.id
            },
        });
    }

    // Autosuggest will call this function every time you need to update suggestions.
    // You already implemented this logic above, so just use it.
    onSuggestionsFetchRequested({ value }){

    };

    // Autosuggest will call this function every time you need to clear suggestions.
    onSuggestionsClearRequested = () => {
        this.setState( {
            suggestions: []
        });
    };
    onChange(event){
        this.props.onChangeInput(event);
    }
    getSuggestionValue(){

    }
    renderSuggestion(suggestion){
       return(
           <div>
               <p>{suggestion.description}</p>
           </div>
       );
    }
    render(){

        return(
            <Autosuggest
                suggestions={this.props.suggestions}
                onSuggestionsFetchRequested={this.onSuggestionsFetchRequested.bind(this)}
                onSuggestionsClearRequested={this.onSuggestionsClearRequested.bind(this)}
                getSuggestionValue={this.getSuggestionValue.bind(this)}
                renderSuggestion={this.renderSuggestion.bind(this)}
                inputProps={this.state.inputProps}
            />
        );
    }
}
export default SuggestionInput;