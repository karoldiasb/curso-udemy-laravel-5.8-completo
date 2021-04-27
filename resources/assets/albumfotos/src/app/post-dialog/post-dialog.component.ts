import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';
import { Post } from '../post';

@Component({
  selector: 'app-post-dialog',
  templateUrl: './post-dialog.component.html',
  styleUrls: ['./post-dialog.component.css']
})
export class PostDialogComponent implements OnInit {

  public nomearquivo: string = '';

  public dados = {
    post: new Post("", "", "", "", ""),
    arquivo: null
  }

  constructor(
    public dialogref: MatDialogRef<PostDialogComponent>
  ) { }

  ngOnInit(): void {
  }

  mudouarquivo(event){
    this.nomearquivo = event.target.files[0].name;
    this.dados.arquivo = event.target.files[0];
  }

  salvar(){
    this.dialogref.close(this.dados);
  }

  cancelar(){
    this.dialogref.close(null);
  }

}
